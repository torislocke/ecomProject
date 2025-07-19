<?php include "header.php"; ?>

<?php
if(!isset($_SESSION['customer'])) {
    header('location: '.BASE_URL.'login');
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
            <li>Customer Dashboard</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="login-page mt-100">
        <div class="container">
            <div class="col-md-12">
                <div class="customer-menu">
                    <?php include "customer-sidebar.php"; ?>
                </div>
                <div class="customer-page-content">
                    <h2>Welcome, <?php echo $_SESSION['customer']['name']; ?>!</h2>
                    <p>You are logged in as a customer. Here you can manage your orders, wishlist, and profile.</p>
                    <p>If you have any questions or need assistance, please contact our support team.</p>
                </div>
            </div>
        </div>
    </div>            
</main>

<?php include "footer.php"; ?>