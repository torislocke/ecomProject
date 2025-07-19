<?php include "header.php"; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM pages WHERE id=?");
$statement->execute([1]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
?>

<!-- breadcrumb start -->
<div class="breadcrumb">
    <div class="container">
        <ul class="list-unstyled d-flex align-items-center m-0">
            <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
            <li class="ml_10 mr_10">
                <i class="fas fa-chevron-right"></i>
            </li>
            <li>Terms of Use</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="about-page">
        <!-- about hero start -->
        <div class="about-hero mt-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <h2 class="mb_20">Terms of Use</h2>
                        <?php echo $result['terms_content']; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- about hero end -->
    </div>            
</main>

<?php include "footer.php"; ?>