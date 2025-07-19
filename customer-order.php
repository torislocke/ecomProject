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
            <li>Customer Orders</li>
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
                                        <th>Order No</th>
                                        <th>Customer Info</th>
                                        <th>Payment Method</th>
                                        <th>Subtotal</th>
                                        <th>Shipping Cost</th>
                                        <th>Coupon Discount</th>
                                        <th>Total</th>
                                        <th>Order Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i=0;
                                    $statement = $pdo->prepare("SELECT * FROM orders WHERE customer_email=? ORDER BY id DESC");
                                    $statement->execute([$_SESSION['customer']['email']]);
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row['order_no']; ?></td>
                                            <td>
                                                <?php
                                                echo $row['customer_name'] . "<br>";
                                                echo $row['customer_email'] . "<br>";
                                                echo $row['customer_phone'] . "<br>";
                                                ?>
                                            </td>
                                            <td><?php echo $row['payment_method']; ?></td>
                                            <td>$<?php echo $row['subtotal']; ?></td>
                                            <td>$<?php echo $row['shipping_cost']; ?></td>
                                            <td>
                                                $<?php echo $row['discount']; ?><br>
                                                (<?php echo $row['coupon_code']; ?>)
                                            </td>
                                            <td>$<?php echo $row['total']; ?></td>
                                            <td><?php echo $row['order_date']; ?></td>
                                            <td>
                                                <?php if($row['status'] == 'Pending'): ?>
                                                    <span class="badge bg-secondary">Pending</span>
                                                <?php elseif($row['status'] == 'Paid'): ?>
                                                    <span class="badge bg-warning">Paid</span>
                                                <?php elseif($row['status'] == 'Processing'): ?>
                                                    <span class="badge bg-info">Processing</span>
                                                <?php elseif($row['status'] == 'Shipped'): ?>
                                                    <span class="badge bg-primary">Shipped</span>
                                                <?php elseif($row['status'] == 'Delivered'): ?>
                                                    <span class="badge bg-success">Completed</span>
                                                <?php elseif($row['status'] == 'Cancelled'): ?>
                                                    <span class="badge bg-danger">Cancelled</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $i; ?>">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo BASE_URL; ?>customer/order-invoice/<?php echo $row['order_no']; ?>" class="btn btn-success btn-sm">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            </td>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal<?php echo $i; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 999999;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Product Detail</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php
                                                            $j=0;
                                                            $statement1 = $pdo->prepare("SELECT * FROM order_details WHERE order_no=?");
                                                            $statement1->execute([$row['order_no']]);
                                                            $products = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($products as $item) {
                                                                $j++;
                                                                ?>
                                                                <p><b>Product <?php echo $j; ?></b></p>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        Product Id
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <?php echo $item['product_id']; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        Product Name
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <?php echo $item['product_name']; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        Product Price
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        $<?php echo $item['product_price']; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        Product Quantity
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <?php echo $item['product_quantity']; ?><br><br>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- // Modal -->

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