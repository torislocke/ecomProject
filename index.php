<?php include "header.php"; ?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<?php
if(isset($_POST['form_add_to_cart'])) {
    try {

        $statement = $pdo->prepare("SELECT * FROM products WHERE id=?");
        $statement->execute([$_POST['id']]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if($result['quantity'] == 0) {
            throw new Exception("Product is out of stock.");
        }

        if(!isset($_SESSION['product_id'])) {
            $_SESSION['product_id'][1] = $_POST['id'];
            $_SESSION['product_quantity'][1] = 1;
        } else {
            $key = array_search($_POST['id'], $_SESSION['product_id']);
            if($_SESSION['product_quantity'][$key] + 1 > $result['quantity']) {
                throw new Exception("Product quantity exceeds available stock.");
            }
            if($key !== false) {
                $_SESSION['product_quantity'][$key] += 1;
            } else {
                $key = count($_SESSION['product_id']) + 1;
                $_SESSION['product_id'][$key] = $_POST['id'];
                $_SESSION['product_quantity'][$key] = 1;
            }
        }

        $_SESSION['success_message'] = "Product added to cart successfully.";
        header("location: " . BASE_URL . "cart.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location: " . BASE_URL);
        exit();
    }
}
?>

<?php
if(isset($_POST['form_wishlist'])) {
    try {

        if(!isset($_SESSION['customer'])) {
            throw new Exception("You must be logged in to add products to your wishlist.");
        }

        // Duplicate check
        $statement = $pdo->prepare("SELECT * FROM wishlists WHERE customer_id=? AND product_id=?");
        $statement->execute([$_SESSION['customer']['id'], $_POST['product_id']]);
        $total = $statement->rowCount();
        if($total > 0) {
            throw new Exception("This product is already in your wishlist.");
        }
        
        // Insert into wishlist
        $statement = $pdo->prepare("INSERT INTO wishlists (customer_id, product_id) VALUES (?, ?)");
        $statement->execute([$_SESSION['customer']['id'], $_POST['product_id']]);

        $_SESSION['success_message'] = "Product added to wishlist successfully.";
        header("location: " . BASE_URL . "customer/wishlist");
        exit();

    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location: " . BASE_URL);
        exit();
    }
}
?>

<?php
if(isset($_POST['form_newsletter'])) {
    try {

        if($_POST['email'] == "") {
            throw new Exception("Email address is required.");
        }
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address format.");
        }
        $statement = $pdo->prepare("SELECT * FROM subscribers WHERE email=?");
        $statement->execute([$_POST['email']]);
        $total = $statement->rowCount();
        if($total > 0) {
            throw new Exception("This email address is already subscribed.");
        }

        $token = bin2hex(random_bytes(10));

        $statement = $pdo->prepare("INSERT INTO subscribers (email,token,status) VALUES (?,?,?)");
        $statement->execute([$_POST['email'], $token, 'Pending']);


        $email_message = "Thank you for subscribing to our newsletter. Please click on the following link to confirm your subscription:<br>";
        $email_message .= '<a href="' . BASE_URL . 'subscription-verify.php?token='.$token.'&email='.$_POST['email'].'">Confirm Subscription</a>';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION;
        $mail->Port = SMTP_PORT;
        $mail->setFrom(SMTP_FROM);
        $mail->addAddress($_POST['email']);
        $mail->isHTML(true);
        $mail->Subject = 'Confirm Your Subscription';
        $mail->Body = $email_message;
        $mail->send();

        $_SESSION['success_message'] = "Thank you for subscribing to our newsletter. Please check your email to confirm your subscription.";
        header("location: " . BASE_URL);
        exit();

    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location: " . BASE_URL);
        exit();
    }
}
?>

<main id="MainContent" class="content-for-layout">
    
    <!-- slideshow start -->
    <div class="slideshow-section position-relative">
        <div class="slideshow-active activate-slider" data-slick='{
            "slidesToShow": 1, 
            "slidesToScroll": 1, 
            "dots": true,
            "arrows": true,
            "responsive": [
                {
                    "breakpoint": 768,
                    "settings": {
                        "arrows": false
                    }
                }
            ]
        }'>

            <?php
            $statement = $pdo->prepare("SELECT * FROM sliders");
            $statement->execute();
            $slider_data = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($slider_data as $item) {
                ?>
                <div class="slide-item position-relative">
                    <img class="slide-img d-none d-md-block" src="<?php echo BASE_URL; ?>uploads/<?php echo $item['photo1']; ?>" alt="slide-1">
                    <img class="slide-img d-md-none" src="<?php echo BASE_URL; ?>uploads/<?php echo $item['photo2']; ?>" alt="slide-1">
                    <div class="content-absolute content-slide">
                        <div class="container height-inherit d-flex align-items-center <?php if($item['text_position'] == 'Right') {echo 'justify-content-end';} ?>">
                            <div class="content-box slide-content py-4">
                                <p class="slide-text heading_24 animate__animated animate__fadeInUp"
                                    data-animation="animate__animated animate__fadeInUp">
                                    <?php echo $item['subheading']; ?>
                                </p>
                                <h2 class="slide-heading heading_72 animate__animated animate__fadeInUp"
                                    data-animation="animate__animated animate__fadeInUp">
                                    <?php echo $item['heading']; ?>
                                </h2>
                                <a class="btn-primary slide-btn animate__animated animate__fadeInUp"
                                    href="<?php echo $item['button_url']; ?>"
                                    data-animation="animate__animated animate__fadeInUp">
                                    <?php echo $item['button_text']; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="activate-arrows"></div>
        <div class="activate-dots dot-tools"></div>
    </div>
    <!-- slideshow end -->



    <!-- banner start -->
    <div class="banner-section mt-100 overflow-hidden">
        <div class="banner-section-inner">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <a class="banner-item position-relative rounded" href="product.php">
                            <img class="banner-img" src="<?php echo BASE_URL; ?>dist-front/img/banner/bag-1.jpg" alt="banner-1">
                            <div class="content-absolute content-slide">
                                <div class="container height-inherit d-flex align-items-center">
                                    <div class="content-box banner-content p-4">
                                        <p class="heading_18 mb-3">Mini Backpack</p>
                                        <h2 class="heading_34">25% off on <br>all bags</h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <a class="banner-item position-relative rounded" href="product.php">
                            <img class="banner-img" src="<?php echo BASE_URL; ?>dist-front/img/banner/bag-2.jpg" alt="banner-2">
                            <div class="content-absolute content-slide">
                                <div class="container height-inherit d-flex align-items-center">
                                    <div class="content-box banner-content p-4">
                                        <p class="heading_18 mb-3">New Year Sell</p>
                                        <h2 class="heading_34">25% off <br>for women</h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- banner end -->

    <!-- collection start -->
    <div class="featured-collection mt-100 overflow-hidden">
        <div class="collection-tab-inner">
            <div class="container">
                <div class="section-header text-center">
                    <h2 class="section-heading">Popular Products</h2>
                </div>
                <div class="row">
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM products ORDER BY total_sale DESC LIMIT 4");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    $total = $statement->rowCount();
                    foreach ($result as $row) {
                        ?>
                        <div class="col-lg-3 col-md-6 col-6">
                            <div class="product-card">
                                <div class="product-card-img">
                                    <a class="hover-switch" href="<?php echo BASE_URL; ?>product/<?php echo $row['slug']; ?>">
                                        <img class="primary-img" src="<?php echo BASE_URL; ?>uploads/<?php echo $row['featured_photo']; ?>" alt="">
                                    </a>

                                    <form action="" method="post" class="product-card-action product-card-action-2">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="addtocart-btn btn-primary" name="form_add_to_cart">ADD TO CART</button>
                                    </form>

                                    <form action="" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="wishlist-btn card-wishlist" name="form_wishlist"><i class="far fa-heart" style="color:#000;font-size:20px;"></i></button>
                                    </form>
                                </div>
                                <div class="product-card-details text-center">
                                    <h3 class="product-card-title"><a href="<?php echo BASE_URL; ?>product/<?php echo $row['slug']; ?>"><?php echo $row['name']; ?></a>
                                    </h3>
                                    <div class="product-card-price">
                                        <span class="card-price-regular">$<?php echo $row['sale_price']; ?></span>
                                        <?php if($row['regular_price'] > $row['sale_price']): ?>
                                        <span class="card-price-compare text-decoration-line-through">$<?php echo $row['regular_price']; ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- collection end -->



    <div class="section-header text-center mt_100 mb_20">
        <h2 class="section-heading">Shop By Category</h2>
    </div>
    <div class="blog-page">
        <div class="blog-page-wrapper">
            <div class="container">
                <div class="row">
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM product_categories ORDER BY name ASC LIMIT 4");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        ?>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="article-card bg-transparent p-0 shadow-none">
                                <a class="article-card-img-wrapper" href="<?php echo BASE_URL; ?>shop.php?name=&category=<?php echo $row['id']; ?>&availability=&min_price=&max_price=">
                                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt="" class="article-card-img rounded">
                                </a>
                                <h2 class="article-card-heading heading_18 text-center">
                                    <a class="heading_18" href="<?php echo BASE_URL; ?>shop.php?name=&category=<?php echo $row['id']; ?>&availability=&min_price=&max_price=">
                                        <?php echo $row['name']; ?>
                                    </a>
                                </h2>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>



    <!-- latest blog start -->
    <div class="latest-blog-section bg-pink mt-100 pt-100 pb-100 overflow-hidden home-section">
        <div class="latest-blog-inner">
            <div class="container">
                <div class="section-header text-center">
                    <h2 class="section-heading">Latest blogs</h2>
                </div>
                <div class="article-card-container position-relative">
                    <div class="common-slider" data-slick='{
                        "slidesToShow": 3, 
                        "slidesToScroll": 1,
                        "dots": false,
                        "arrows": true,
                        "responsive": [
                            {
                            "breakpoint": 1281,
                            "settings": {
                                "slidesToShow": 2
                            }
                            },
                            {
                            "breakpoint": 602,
                            "settings": {
                                "slidesToShow": 1
                            }
                            }
                        ]
                    }'>
                        
                        <?php
                        $statement = $pdo->prepare("SELECT p.*, pc.name AS post_category_name 
                                    FROM posts p
                                    JOIN post_categories pc 
                                    ON p.post_category_id = pc.id
                                    ORDER BY p.id DESC
                                    LIMIT 3
                                ");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result as $row) {
                            ?>
                            <div class="article-slick-item">
                                <div class="article-card">
                                    <a class="article-card-img-wrapper" href="<?php echo BASE_URL; ?>post/<?php echo $row['slug']; ?>">
                                        <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt="" class="article-card-img rounded">
                                    </a>
                                    <p class="article-card-published text_12">
                                        <?php echo date('F j, Y', strtotime($row['updated_at'])); ?>
                                    </p>
                                    <h2 class="article-card-heading heading_18">
                                        <a class="heading_18" href="<?php echo BASE_URL; ?>post/<?php echo $row['slug']; ?>">
                                            <?php echo $row['title']; ?>
                                        </a>
                                    </h2>
                                    <a class="article-card-read-more text_14 link-underline" href="<?php echo BASE_URL; ?>post/<?php echo $row['slug']; ?>">Read More</a>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="activate-arrows show-arrows-always article-arrows arrows-white"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- latest blog end -->


    <!-- faq start -->
    <div class="faq-section mt-100 overflow-hidden">
        <div class="faq-inner">
            <div class="container">
                <div class="section-header text-center">
                    <h2 class="section-heading">Frequently Asked Question</h2>
                    <p class="section-subheading">All your questions about Axion answered </p>
                </div>
                <div class="faq-container">
                    <div class="row">
                        <?php
                        $i=0;
                        $statement = $pdo->prepare("SELECT * FROM faqs LIMIT 6");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $i++;
                            ?>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="faq-item rounded">
                                    <h2 class="faq-heading heading_18 collapsed d-flex align-items-center justify-content-between"
                                        data-bs-toggle="collapse" data-bs-target="#faq<?php echo $i; ?>">
                                        <?php echo $row['question']; ?>
                                        <span class="faq-heading-icon">
                                            <i class="fas fa-chevron-down"></i>
                                        </span>
                                    </h2>
                                    <div id="faq<?php echo $i; ?>" class="accordion-collapse collapse">
                                        <p class="faq-body text_14">
                                            <?php echo nl2br($row['answer']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="view-all text-center">
                        <a class="btn-primary" href="<?php echo BASE_URL; ?>faq">SEE MORE</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- faq end -->

    <!-- newsletter start -->
    <div class="newsletter-section mt-100 overflow-hidden">
        <div class="newsletter-inner">
            <div class="container">
                <div class="newsletter-container bg-pink">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-12">
                            <div class="newsletter-content newsltter-content-1">
                                <div class="newsletter-header">
                                    <p class="newsletter-subheading colored-text heading_24">NewsLetter</p>
                                    <h2 class="newsletter-heading heading_42">Subscribe to our newsletter</h2>
                                </div>
                                <div class="newsletter-form-wrapper">
                                    <form action="" class="newsletter-form d-flex align-items-center rounded" method="post">
                                        <input class="newsletter-input bg-transparent border-0" type="email"
                                            placeholder="Enter your e-mail" autocomplete="off" name="email">
                                        <button class="newsletter-btn rounded" type="submit" name="form_newsletter">
                                            <i class="fas fa-arrow-right text-white"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="newsletter-image">
                                <img src="<?php echo BASE_URL; ?>dist-front/img/newsletter/1.jpg" alt="img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- newsletter end -->


    <!-- brand logo start -->
    <div class="brand-logo-section mt-100">
        <div class="brand-logo-inner">
            <div class="container">
                <div class="brand-logo-container overflow-hidden">
                    <div class="scroll-horizontal row align-items-center flex-nowrap">
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                            <a href="index.php" class="brand-logo d-flex align-items-center justify-content-center">
                                <img src="<?php echo BASE_URL; ?>dist-front/img/brand/1.png" alt="img">
                            </a>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                            <a href="index.php" class="brand-logo d-flex align-items-center justify-content-center">
                                <img src="<?php echo BASE_URL; ?>dist-front/img/brand/2.png" alt="img">
                            </a>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                            <a href="index.php" class="brand-logo d-flex align-items-center justify-content-center">
                                <img src="<?php echo BASE_URL; ?>dist-front/img/brand/3.png" alt="img">
                            </a>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                            <a href="index.php" class="brand-logo d-flex align-items-center justify-content-center">
                                <img src="<?php echo BASE_URL; ?>dist-front/img/brand/4.png" alt="img">
                            </a>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                            <a href="index.php" class="brand-logo d-flex align-items-center justify-content-center">
                                <img src="<?php echo BASE_URL; ?>dist-front/img/brand/5.png" alt="img">
                            </a>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                            <a href="index.php" class="brand-logo d-flex align-items-center justify-content-center">
                                <img src="<?php echo BASE_URL; ?>dist-front/img/brand/6.png" alt="img">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- brand logo end -->
</main>

<?php include "footer.php"; ?>