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
            <li>Customer Wishlists</li>
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
                    <div class="table-responsive">
                        <div class="table table-bordered">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Product Photo</th>
                                        <th>Product Name</th>
                                        <th>Product Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i=0;
                                    $statement = $pdo->prepare("SELECT w.*,
                                                        p.name as product_name,
                                                        p.sale_price as product_price,
                                                        p.featured_photo as product_photo,
                                                        p.slug as product_slug
                                                        FROM wishlists w
                                                        JOIN products p
                                                        ON w.product_id = p.id 
                                                        WHERE w.customer_id=?");
                                    $statement->execute([$_SESSION['customer']['id']]);
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td>
                                                <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['product_photo']; ?>" alt="" style="width:140px;">
                                            </td>
                                            <td>
                                                <a href="<?php echo BASE_URL; ?>product/<?php echo $row['product_slug']; ?>"><?php echo $row['product_name']; ?></a>
                                            </td>
                                            <td>$<?php echo $row['product_price']; ?></td>
                                            <td>
                                                <a href="customer-wishlist-delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include "footer.php"; ?>