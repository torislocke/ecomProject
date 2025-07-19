<?php include "header.php"; ?>

<?php
if(isset($_POST['order_no']) ) {
    $statement = $pdo->prepare("SELECT * FROM orders WHERE order_no=?");
    $statement->execute([$_POST['order_no']]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $total = $statement->rowCount();
    if($total == 0) {
        $error_message = "Order not found";
        $_SESSION['error_message'] = $error_message;
        header('location: '.BASE_URL.'tracking.php');
        exit;
    } else {
        $_SESSION['status'] = $result['status'];
        header('location: '.BASE_URL.'tracking.php');
        exit;
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
            <li>Order Tracking</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="login-page mt-100">
        <div class="container">
            <form action="" class="login-form common-form mx-auto" method="post" style="max-width: 600px;">
                <div class="section-header mb-3">
                    <h2 class="section-heading text-center">Order Tracking</h2>
                </div>
                <div class="row">
                    <div class="col-12">
                        <fieldset>
                            <label class="label">Order Number</label>
                            <input type="text" name="order_no">
                        </fieldset>
                    </div>

                    <?php if(isset($_SESSION['status'])): ?>
                    <div class="col-12">
                        <fieldset>
                            <label class="label" style="font-size: 20px;font-weight:700;">Order Status: <?php echo $_SESSION['status']; ?></label>
                        </fieldset>
                    </div>
                    <?php unset($_SESSION['status']); endif; ?>

                    <div class="col-12 mt-3">
                        <button type="submit" class="btn-primary d-block mt-4 btn-signin" name="form_submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include "footer.php"; ?>