<?php include 'layouts/top.php'; ?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<?php
if(isset($_POST['form_change_status'])) {

    // Getting customer information
    $statement = $pdo->prepare("SELECT * FROM orders WHERE order_no=?");
    $statement->execute([$_POST['order_no']]);
    $order_data = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare("UPDATE orders SET status=? WHERE order_no=?");
    $statement->execute([$_POST['status'],$_POST['order_no']]);

    // Send email notification to customer
    $customer_email = $order_data['customer_email'];
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = SMTP_ENCRYPTION;
    $mail->Port = SMTP_PORT;
    $mail->setFrom(SMTP_FROM);
    $mail->addAddress($customer_email);
    $mail->isHTML(true);
    $mail->Subject = 'Order Status Update';
    $email_message = "Dear " . $order_data['customer_name'] . ",<br><br>";
    $email_message .= "Your order with order number <b>" . $order_data['order_no'] . "</b> has been updated to <b>" . $_POST['status'] . "</b>.<br><br>";
    $email_message .= "Thank you for shopping with us!<br><br>";
    $email_message .= "Best regards,<br>";
    $email_message .= "Your Company Name";
    $mail->Body = $email_message;
    $mail->send();


    $_SESSION['success_message'] = 'Order status has been changed successfully.';
    header('location: '.ADMIN_URL.'order-view.php');
    exit();
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Orders</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example1">
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
                                        $statement = $pdo->prepare("SELECT * FROM orders ORDER BY id DESC");
                                        $statement->execute();
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
                                                    $<?php echo $row['discount']; ?>
                                                    <?php if($row['discount']!=0): ?>
                                                    <br>(<?php echo $row['coupon_code']; ?>)
                                                    <?php endif; ?>
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
                                                        <span class="badge bg-success">Delivered</span>
                                                    <?php elseif($row['status'] == 'Cancelled'): ?>
                                                        <span class="badge bg-danger">Cancelled</span>
                                                    <?php endif; ?>
                                                    <br>
                                                    <a href="" data-bs-toggle="modal" data-bs-target="#changeModal<?php echo $i; ?>">Change</a>
                                                </td>
                                                <td>
                                                    <a href="" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $i; ?>">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="order-invoice.php?order_no=<?php echo $row['order_no']; ?>" class="btn btn-success btn-sm">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                </td>
                                            </tr>
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

                                            <!-- Modal -->
                                            <div class="modal fade" id="changeModal<?php echo $i; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 999999;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Change Status</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="" method="post">
                                                                <input type="hidden" name="order_no" value="<?php echo $row['order_no']; ?>">
                                                                <div class="form-group
                                                                <div class="mb-2">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <select name="status" id="status" class="form-select">
                                                                        <option value="Pending" <?php if($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                                                        <option value="Paid" <?php if($row['status'] == 'Paid') echo 'selected'; ?>>Paid</option>
                                                                        <option value="Processing" <?php if($row['status'] == 'Processing') echo 'selected'; ?>>Processing</option>
                                                                        <option value="Shipped" <?php if($row['status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                                                                        <option value="Delivered" <?php if($row['status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                                                                        <option value="Cancelled" <?php if($row['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <button type="submit" class="btn btn-primary" name="form_change_status">Submit</button>
                                                                </div>
                                                            </form>
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
    </section>
</div>

<?php include 'layouts/footer.php'; ?>