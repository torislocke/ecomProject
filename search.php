<?php include "header.php"; ?>

<!-- breadcrumb start -->
<div class="breadcrumb">
    <div class="container">
        <ul class="list-unstyled d-flex align-items-center m-0">
            <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
            <li class="ml_10 mr_10">
                <i class="fas fa-chevron-right"></i>
            </li>
            <li>Search By: <?php echo $_REQUEST['q']; ?></li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="blog-page mt-100">
        <div class="blog-page-wrapper">
            <div class="container">

                <?php
                $q = $pdo->prepare("SELECT p.*, pc.name AS post_category_name 
                                    FROM posts p
                                    JOIN post_categories pc 
                                    ON p.post_category_id = pc.id
                                    WHERE p.title LIKE ? OR p.content LIKE ?
                                    ORDER BY p.id DESC
                                ");
                $q->execute(["%".$_REQUEST['q']."%", "%".$_REQUEST['q']."%"]);
                $total = $q->rowCount();
                ?>

                <div class="row">

                    <?php
                    $per_page = 6;
                    $total_pages = ceil($total/$per_page);    

                    if(!isset($_REQUEST['p'])) {
                        $start = 1;
                    } else {
                        $start = $per_page * ($_REQUEST['p']-1) + 1;
                    }

                    $j=0;
                    $k=0;
                    $arr1 = [];
                    $res = $q->fetchAll();
                    foreach($res as $row) {
                        $j++;
                        if($j>=$start) {
                            $k++;
                            if($k>$per_page) {break;}
                            $arr1[] = $row['id'];
                        }
                    }

                    $statement = $pdo->prepare("SELECT p.*, pc.name AS post_category_name 
                                    FROM posts p
                                    JOIN post_categories pc 
                                    ON p.post_category_id = pc.id
                                    WHERE p.title LIKE ? OR p.content LIKE ?
                                    ORDER BY p.id DESC
                                ");
                    $statement->execute(["%".$_REQUEST['q']."%", "%".$_REQUEST['q']."%"]);
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    $total_row = $statement->rowCount();
                    foreach ($result as $row) {
                        if(!in_array($row['id'],$arr1)) {
                            continue;
                        }
                        ?>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="article-card bg-transparent p-0 shadow-none post-section">
                                <a class="article-card-img-wrapper" href="<?php echo BASE_URL; ?>post/<?php echo $row['slug']; ?>">
                                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt="" class="article-card-img rounded">
                                    <span class="article-tag article-tag-absolute rounded"><?php echo $row['post_category_name']; ?></span>
                                </a>
                                <p class="article-card-published text_12 d-flex align-items-center">
                                    <span class="article-date d-flex align-items-center">
                                        <i class="far fa-calendar-alt" style="font-size:16px;"></i>
                                        <span class="ms-2"><?php echo date("d F, Y", strtotime($row['updated_at'])); ?></span>
                                    </span>
                                    <span class="article-author d-flex align-items-center ms-4">
                                        <i class="far fa-user" style="font-size:16px;"></i>
                                        <span class="ms-2">Admin</span>
                                    </span>
                                </p>
                                <h2 class="article-card-heading heading_18">
                                    <a class="heading_18" href="<?php echo BASE_URL; ?>post/<?php echo $row['slug']; ?>">
                                        <?php echo $row['title']; ?>
                                    </a>
                                </h2>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>


                <?php if($per_page < $total_row): ?>
                <div class="pagination justify-content-center mt-100">
                    <nav>
                        <ul class="pagination m-0 d-flex align-items-center">

                            <?php
                            $common_url = BASE_URL.'search.php?q='.$_REQUEST['q'];
                            if(isset($_REQUEST['p'])) {
                                if($_REQUEST['p'] == 1) {
                                    ?>
                                    <li class="item">
                                        <a class="link" href="javascript:void;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-left">
                                                <polyline points="15 18 9 12 15 6"></polyline>
                                            </svg>
                                        </a>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li class="item">
                                        <a class="link" href="<?php echo $common_url; ?>&p=<?php echo $_REQUEST['p']-1; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-left">
                                                <polyline points="15 18 9 12 15 6"></polyline>
                                            </svg>
                                        </a>
                                    </li>
                                    <?php
                                }
                            } else {
                                ?>
                                <li class="item">
                                        <a class="link" href="javascript:void;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-left">
                                                <polyline points="15 18 9 12 15 6"></polyline>
                                            </svg>
                                        </a>
                                    </li>
                                <?php
                            }
                            ?>


                            <?php
                            for($i=1;$i<=$total_pages;$i++) {
                                ?>
                                <li class="item"><a class="link" href="<?php echo $common_url; ?>&p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php
                            }
                            ?>


                            <?php
                            if(isset($_REQUEST['p'])) {
                                if($_REQUEST['p'] == $total_pages) {
                                    ?>
                                    <li class="item">
                                        <a class="link" href="javascript:void;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-right">
                                                <polyline points="9 18 15 12 9 6"></polyline>
                                            </svg>
                                        </a>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li class="item">
                                        <a class="link" href="<?php echo $common_url; ?>&p=<?php echo $_REQUEST['p']+1; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-right">
                                                <polyline points="9 18 15 12 9 6"></polyline>
                                            </svg>
                                        </a>
                                    </li>
                                    <?php
                                }
                            } else {
                                ?>
                                <li class="item">
                                    <a class="link" href="<?php echo $common_url; ?>&p=2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-right">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>


            </div>
        </div>            
    </div>            
</main>

<?php include "footer.php"; ?>