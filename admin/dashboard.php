<?php include 'layouts/top.php'; ?>

<?php
if(!isset($_SESSION['admin'])) {
    header('location: '.ADMIN_URL.'login.php');
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM product_categories");
$statement->execute();
$total_product_categories = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM products");
$statement->execute();
$total_products = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM coupons WHERE status = ?");
$statement->execute(['Active']);
$total_active_coupons = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM areas");
$statement->execute();
$total_areas = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM customers WHERE status = ?");
$statement->execute(['Active']);
$total_customers = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM orders");
$statement->execute();
$total_orders = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM subscribers WHERE status = ?");
$statement->execute(['Active']);
$total_active_subscribers = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM posts");
$statement->execute();
$total_posts = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM comments WHERE status = ?");
$statement->execute(['Approved']);
$total_comments = $statement->rowCount();
?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-arrow-circle-right"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Product Categories</h4>
                        </div>
                        <div class="card-body">
                            <?php echo $total_product_categories; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-arrow-circle-right"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Products</h4>
                        </div>
                        <div class="card-body">
                            <?php echo $total_products; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-arrow-circle-right"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Active Coupons</h4>
                        </div>
                        <div class="card-body">
                            <?php echo $total_active_coupons; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-arrow-circle-right"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Areas</h4>
                        </div>
                        <div class="card-body">
                            <?php echo $total_areas; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-arrow-circle-right"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Active Customers</h4>
                        </div>
                        <div class="card-body">
                            <?php echo $total_customers; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-arrow-circle-right"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Orders</h4>
                        </div>
                        <div class="card-body">
                            <?php echo $total_orders; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-arrow-circle-right"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Active Subscribers</h4>
                        </div>
                        <div class="card-body">
                            <?php echo $total_active_subscribers; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-arrow-circle-right"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Posts</h4>
                        </div>
                        <div class="card-body">
                            <?php echo $total_posts; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-arrow-circle-right"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Comments</h4>
                        </div>
                        <div class="card-body">
                            <?php echo $total_comments; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'layouts/footer.php'; ?>