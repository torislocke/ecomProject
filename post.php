<?php include "header.php"; ?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<?php
$statement = $pdo->prepare("SELECT p.*, pc.name AS post_category_name
                        FROM posts p
                        JOIN post_categories pc
                        ON p.post_category_id = pc.id
                        WHERE p.slug=?");
$statement->execute([$_REQUEST['slug']]);
$post_data = $statement->fetch(PDO::FETCH_ASSOC);
$total = $statement->rowCount();
if ($total == 0) {
    header("location: ".BASE_URL."blog.php");
    exit();
}
?>

<?php
if(isset($_POST['form_comment'])) {
    try {

        if($_POST['name'] == '') {
            throw new Exception("Name is required.");
        }
        if($_POST['email'] == '') {
            throw new Exception("Email is required.");
        }
        if($_POST['content'] == '') {
            throw new Exception("Comment content is required.");
        }

        $current_date = date("Y-m-d");

        $statement = $pdo->prepare("INSERT INTO comments (post_id,name,email,content,publish_date,status) VALUES (?,?,?,?,?,?)");
        $statement->execute([$post_data['id'],$_POST['name'],$_POST['email'],$_POST['content'],$current_date,'Pending']);

        $statement = $pdo->prepare("SELECT * FROM admins WHERE id=?");
        $statement->execute([1]);
        $admin_data = $statement->fetch(PDO::FETCH_ASSOC);

        $email_message = "A new comment has been posted on your blog post.<br>";
        $email_message .= "Name: " . $_POST['name'] . "<br>";
        $email_message .= "Email: " . $_POST['email'] . "<br>";
        $email_message .= "Content: " . $_POST['content'] . "<br>";
        $email_message .= "Date: " . $current_date . "<br><br>";
        $email_message .= "You can view the comment by clicking on the link below:<br>";
        $email_message .= '<a href="'.ADMIN_URL.'comment-view.php">View Comment</a>';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION;
        $mail->Port = SMTP_PORT;
        $mail->setFrom(SMTP_FROM);
        $mail->addAddress($admin_data['email']);
        $mail->isHTML(true);
        $mail->Subject = 'New Comment Notification';
        $mail->Body = $email_message;
        $mail->send();

        $_SESSION['success_message'] = 'Your comment has been submitted successfully and is awaiting approval.';
        header("location: ".BASE_URL."post/".$_REQUEST['slug']);
        exit();
    } catch(Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header("location: ".BASE_URL."post/".$_REQUEST['slug']);
        exit();
    }
}
?>

<?php
if(isset($_POST['form_reply'])) {
    try {

        if($_POST['name'] == '') {
            throw new Exception("Name is required.");
        }
        if($_POST['email'] == '') {
            throw new Exception("Email is required.");
        }
        if($_POST['content'] == '') {
            throw new Exception("Comment content is required.");
        }

        $current_date = date("Y-m-d");

        $statement = $pdo->prepare("INSERT INTO replies (post_id,comment_id,name,email,content,publish_date,status) VALUES (?,?,?,?,?,?,?)");
        $statement->execute([$_POST['post_id'],$_POST['comment_id'],$_POST['name'],$_POST['email'],$_POST['content'],$current_date,'Pending']);

        $statement = $pdo->prepare("SELECT * FROM admins WHERE id=?");
        $statement->execute([1]);
        $admin_data = $statement->fetch(PDO::FETCH_ASSOC);

        $email_message = "A new reply has been posted on your blog post.<br>";
        $email_message .= "Name: " . $_POST['name'] . "<br>";
        $email_message .= "Email: " . $_POST['email'] . "<br>";
        $email_message .= "Content: " . $_POST['content'] . "<br>";
        $email_message .= "Date: " . $current_date . "<br><br>";
        $email_message .= "You can view the reply by clicking on the link below:<br>";
        $email_message .= '<a href="'.ADMIN_URL.'comment-view.php">View Reply</a>';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION;
        $mail->Port = SMTP_PORT;
        $mail->setFrom(SMTP_FROM);
        $mail->addAddress($admin_data['email']);
        $mail->isHTML(true);
        $mail->Subject = 'New Reply Notification';
        $mail->Body = $email_message;
        $mail->send();

        $_SESSION['success_message'] = 'Your reply has been submitted successfully and is awaiting approval.';
        header("location: ".BASE_URL."post/".$_REQUEST['slug']);
        exit();
    } catch(Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header("location: ".BASE_URL."post/".$_REQUEST['slug']);
        exit();
    }
}
?>

<!-- breadcrumb start -->
<div class="breadcrumb">
    <div class="container">
        <ul class="list-unstyled d-flex align-items-center m-0">
            <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
            <li class="ml_10 mr_10">
                <i class="fas fa-chevron-right"></i>
            </li>
            <li><a href="<?php echo BASE_URL; ?>blog.php">Blog</a></li>
            <li class="ml_10 mr_10">
                <i class="fas fa-chevron-right"></i>
            </li>
            <li><?php echo $post_data['title']; ?></li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="article-page mt-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12 col-12">
                    <div class="article-rte">
                        <div class="article-img">
                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo $post_data['photo']; ?>" alt="img">
                        </div>
                        <div class="article-meta">
                            <h2 class="article-title"><?php echo $post_data['title']; ?></h2>
                            <div class="article-card-published text_14 d-flex align-items-center">
                                <span class="article-author d-flex align-items-center">
                                    <i class="far fa-user" style="font-size:16px;"></i>
                                    <span class="ms-2">Admin</span>
                                </span>
                                <span class="article-separator mx-3">|</span>
                                <a href="" class="article-date d-flex align-items-center">
                                    <span class="icon-publish">
                                        <i class="far fa-comment-alt"></i>
                                    </span>
                                    <span class="ms-2">3 Comments</span>
                                </a>
                                <span class="article-separator mx-3 d-none d-sm-block">|</span>
                                <a href="post.php" class="article-date d-none d-sm-flex align-items-center">
                                    <span class="icon-tag">
                                        <i class="fas fa-th-large"></i>
                                    </span>
                                    <span class="ms-2"><?php echo $post_data['post_category_name']; ?></span>
                                </a>
                            </div>
                        </div>

                        <div class="article-content">
                            <?php echo $post_data['content']; ?>
                        </div>

                        <?php if($post_data['tags'] != ''): ?>
                        <div class="post_tags">
                            <ul>
                                <?php
                                $tags = explode(',', $post_data['tags']);
                                foreach ($tags as $tag) {
                                    ?>
                                    <li><a href="<?php echo BASE_URL; ?>tag/<?php echo $tag; ?>/1"><?php echo trim($tag); ?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <?php
                        $statement = $pdo->prepare("SELECT * FROM posts WHERE id < ? ORDER BY id DESC LIMIT 1");
                        $statement->execute([$post_data['id']]);
                        $prev_article_data = $statement->fetch(PDO::FETCH_ASSOC);
                        if($prev_article_data) {
                            $prev_anchor = BASE_URL.'post/'.$prev_article_data['slug'];
                        } else {
                            $prev_anchor = 'javascript:void(0);';
                        }

                        $statement = $pdo->prepare("SELECT * FROM posts WHERE id > ? ORDER BY id ASC LIMIT 1");
                        $statement->execute([$post_data['id']]);
                        $next_article_data = $statement->fetch(PDO::FETCH_ASSOC);
                        if($next_article_data) {
                            $next_anchor = BASE_URL.'post/'.$next_article_data['slug'];
                        } else {
                            $next_anchor = 'javascript:void(0);';
                        }


                        ?>

                        <div class="next-prev-article mt-5 d-flex align-items-center justify-content-between">
                            <a href="<?php echo $prev_anchor; ?>" class="article-btn prev-article-btn mt-2">PREV ARTICLE</a>
                            <a href="<?php echo $next_anchor; ?>" class="article-btn next-article-btn active mt-2">NEXT ARTICLE</a>
                        </div>



                        <?php
                        $statement = $pdo->prepare("SELECT * FROM comments WHERE post_id=? AND status=?");
                        $statement->execute([$post_data['id'], 'Approved']);
                        $all_comments = $statement->fetchAll(PDO::FETCH_ASSOC);
                        $total_comments = $statement->rowCount();
                        ?>




                        <div class="comments-section mt-100 home-section overflow-hidden">
                            <div class="section-header">
                                <h2 class="section-heading">Comments - <?php echo $total_comments; ?></h2>
                            </div>







                            <div class="comments-area">


                                <?php
                                $i=0;
                                foreach ($all_comments as $row) {
                                    $i++;
                                    ?>
                                    <div class="d-flex comments-item">
                                        <div class="comments-img">
                                            <?php
                                            $email = $row['email'];
                                            $default = "retro"; // Default image if no gravatar exists (can be: 'mp', 'identicon', 'monsterid', 'wavatar', 'retro', etc.)
                                            $size = 80; // Size in pixels
                                            $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?s=" . $size . "&d=" . $default;
                                            ?>
                                            <img src="<?php echo $grav_url; ?>" alt="Gravatar">
                                        </div>
                                        <div class="comments-main">
                                            <div class="comments-main-content">
                                                <div class="comments-meta">
                                                    <h4 class="commentator-name"><?php echo $row['name']; ?></h4>
                                                    <div class="comments-date article-date d-flex align-items-center">
                                                        <span class="icon-publish">
                                                            <i class="far fa-calendar-alt" style="font-size:16px;"></i>
                                                        </span>
                                                        <span class="ms-2">
                                                            <?php echo date("d F, Y", strtotime($row['publish_date'])); ?>
                                                        </span>
                                                    </div>
                                                    <p class="comments"><?php echo nl2br($row['content']); ?></p>
                                                </div>
                                                <button type="button" class="btn-reply bg-transparent d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#replyModal<?php echo $i; ?>">
                                                    <span class="btn-reply-icon me-2">
                                                        <i class="fas fa-reply-all"></i>
                                                    </span>
                                                    <span class="btn-reply-text">Reply</span>
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="replyModal<?php echo $i; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Reply</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="" method="post">
                                                                    <input type="hidden" name="post_id" value="<?php echo $post_data['id']; ?>">
                                                                    <input type="hidden" name="comment_id" value="<?php echo $row['id']; ?>">
                                                                    <div class="mb-2">
                                                                        <label for="">Name</label>
                                                                        <input type="text" name="name" class="form-control">
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <label for="">Email</label>
                                                                        <input type="email" name="email" class="form-control">
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <label for="">Comment</label>
                                                                        <textarea name="content" class="form-control" rows="5"></textarea>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary" name="form_reply">Submit</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                            <?php
                                            $statement1 = $pdo->prepare("SELECT * FROM replies WHERE comment_id=? AND status=?");
                                            $statement1->execute([$row['id'], 'Approved']);
                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            $total1 = $statement1->rowCount();
                                            foreach ($result1 as $row1) {
                                                ?>
                                                <div class="comments-replied">
                                                    <div class="d-flex comments-item">
                                                        <div class="comments-img">
                                                            <?php
                                                            $email1 = $row1['email'];
                                                            $default1 = "retro"; // Default image if no gravatar exists (can be: 'mp', 'identicon', 'monsterid', 'wavatar', 'retro', etc.)
                                                            $size1 = 80; // Size in pixels
                                                            $grav_url1 = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email1))) . "?s=" . $size1 . "&d=" . $default1;
                                                            ?>
                                                            <img src="<?php echo $grav_url1; ?>" alt="Gravatar">
                                                        </div>
                                                        <div class="comments-main">
                                                            <div class="comments-meta">
                                                                <h4 class="commentator-name"><?php echo $row1['name']; ?></h4>
                                                                <div class="comments-date article-date d-flex align-items-center">
                                                                    <span class="icon-publish">
                                                                        <i class="far fa-calendar-alt" style="font-size:16px;"></i>
                                                                    </span>
                                                                    <span class="ms-2"><?php echo date('d F, Y', strtotime($row1['publish_date'])); ?></span>
                                                                </div>
                                                                <p class="comments">
                                                                    <?php echo nl2br($row1['content']); ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            



                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>




                                




                            </div>









                            <div class="comment-form-area">
                                <div class="form-header">
                                    <h4 class="form-title">Leave A Reply</h4>
                                    <p class="form-subtitle">All fields marked with an asterisk (*) are required</p>
                                </div>
                                <form action="" class="comment-form" method="post">
                                    <div class="name-email-field d-flex justify-content-between">
                                        <div class="field-item name-field">
                                            <input type="text" placeholder="Name *" name="name" required>
                                        </div>
                                        <div class="field-item email-field">
                                            <input type="email" placeholder="Email *" name="email" required>
                                        </div>
                                    </div>
                                    <div class="field-item textarea-field">
                                        <textarea cols="20" rows="6" placeholder="Comment *" name="content"></textarea>
                                    </div>
                                    <button type="submit" class="position-relative review-submit-btn mt-4" name="form_comment">SUBMIT</button>
                                </form>
                            </div>


                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-12">
                    <div class="filter-drawer blog-sidebar">
                        


                        <div class="filter-widget">
                            <div class="filter-header faq-heading heading_18 d-flex align-items-center justify-content-between border-bottom">
                                Search
                            </div>
                            <div class="accordion-collapse">
                                <form action="<?php echo BASE_URL; ?>search.php" method="get" class="search-form d-flex align-items-center mt_10">
                                    <input type="text" class="form-control" name="q" placeholder="Title or Content" required>
                                    <button type="submit"><i class="fas fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                        


                        <div class="filter-widget">
                            <div class="filter-header faq-heading heading_18 d-flex align-items-center justify-content-between border-bottom">
                                Categories
                            </div>
                            <div class="accordion-collapse">
                                <ul class="filter-lists list-unstyled mb-0">
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM post_categories ORDER BY name ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        ?>
                                        <li class="filter-item">
                                            <a class="filter-label" href="<?php echo BASE_URL; ?>category/<?php echo $row['slug']; ?>/1">
                                                <i class="fas fa-chevron-right mr_10"></i>
                                                <?php echo $row['name']; ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>





                        <div class="filter-widget">
                            <div class="filter-header faq-heading heading_18 d-flex align-items-center border-bottom">
                                Latest Post
                            </div>
                            <div class="filter-related">
                                <?php
                                $statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT 5");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    ?>
                                    <div class="related-item related-item-article d-flex">
                                        <div class="related-img-wrapper">
                                            <img class="related-img" src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt="img">
                                        </div>
                                        <div class="related-product-info">
                                            <h2 class="related-heading text_14">
                                                <a href="<?php echo BASE_URL; ?>post/<?php echo $row['slug']; ?>"><?php echo $row['title']; ?></a>
                                            </h2>
                                            <p class="article-card-published text_12 d-flex align-items-center mt-2">
                                                <span class="article-date d-flex align-items-center">
                                                    <span class="icon-publish">
                                                        <i class="far fa-calendar-alt" style="font-size:16px;"></i>
                                                    </span>
                                                    <span class="ms-2"><?php echo date("d F, Y", strtotime($row['updated_at'])); ?></span>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>






                        <div class="filter-widget">
                            <div class="filter-header faq-heading heading_18 d-flex align-items-center justify-content-between border-bottom">
                                Popular Tags
                            </div>
                            <ul class="filter-tags list-unstyled">
                                <?php
                                $all_tags = [];
                                $statement = $pdo->prepare("SELECT * FROM posts");
                                $statement->execute();
                                $post_all = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($post_all as $row) {
                                    if($row['tags'] == '') {
                                        continue;
                                    }
                                    $tags = explode(',', $row['tags']);
                                    foreach ($tags as $tag) {
                                        $tag = trim($tag);
                                        if(!in_array($tag, $all_tags)) {
                                            $all_tags[] = $tag;
                                        }
                                    }
                                }
                                ?>
                                <?php
                                for($i=0;$i<count($all_tags);$i++) {
                                    ?>
                                    <li class="tag-item"><a href="<?php echo BASE_URL; ?>tag/<?php echo $all_tags[$i]; ?>/1"><?php echo $all_tags[$i]; ?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>            
</main>

<?php include "footer.php"; ?>