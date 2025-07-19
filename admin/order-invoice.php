<?php include 'layouts/top.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM orders WHERE order_no=?");
$statement->execute([$_REQUEST['order_no']]);
$order_data = $statement->fetch(PDO::FETCH_ASSOC);
$total = $statement->rowCount();
if($total == 0) {
    header('location: '.BASE_URL.'customer/order');
}

$statement = $pdo->prepare("SELECT * FROM order_details WHERE order_no=?");
$statement->execute([$_REQUEST['order_no']]);
$order_detail_data = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $pdo->prepare("SELECT * FROM admins WHERE id=?");
$statement->execute([1]);
$admin_data = $statement->fetch(PDO::FETCH_ASSOC);
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Invoice</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>order-view.php" class="btn btn-primary"><i class="fas fa-eye"></i> Back to Previous</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="invoice-container" id="print_invoice">
                                <div class="invoice-top">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-border-0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w-50">
                                                                <img src="<?php echo BASE_URL; ?>uploads/<?php echo $setting_data['logo']; ?>" alt="" class="w-100">
                                                            </td>
                                                            <td class="w-50">
                                                                <div class="invoice-top-right">
                                                                    <h4>Invoice</h4>
                                                                    <h5>Order No: <?php echo $_REQUEST['order_no']; ?></h5>
                                                                    <h5>Date: <?php echo $order_data['order_date']; ?></h5>
                                                                    <h5>Status: <?php echo $order_data['status']; ?></h5>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice-middle">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-border-0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w-50">
                                                                <div class="invoice-middle-left">
                                                                    <h4>Invoice To:</h4>
                                                                    <p class="mb_0"><?php echo $order_data['customer_name']; ?></p>
                                                                    <p class="mb_0"><?php echo $order_data['customer_email']; ?></p>
                                                                    <p class="mb_0"><?php echo $order_data['customer_phone']; ?></p>
                                                                    <p class="mb_0"><?php echo $order_data['customer_address']; ?></p>
                                                                </div>
                                                            </td>
                                                            <td class="w-50">
                                                                <div class="invoice-middle-right">
                                                                    <h4>Invoice From:</h4>
                                                                    <p class="mb_0"><?php echo $admin_data['name']; ?></p>
                                                                    <p class="mb_0 color_6d6d6d"><?php echo $admin_data['email']; ?></p>
                                                                    <p class="mb_0">222-333-4444</p>
                                                                    <p class="mb_0">43, ABC Road, USA</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice-item">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered invoice-item-table">
                                                    <tbody>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>Product Name</th>
                                                            <th>Price</th>
                                                            <th>Quantity</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                        <?php
                                                        $i=0;
                                                        foreach($order_detail_data as $row) {
                                                            $i++;
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo $row['product_name']; ?></td>
                                                                <td>$<?php echo number_format($row['product_price'], 2); ?></td>
                                                                <td><?php echo $row['product_quantity']; ?></td>
                                                                <td>
                                                                    <?php
                                                                    $subtotal = $row['product_price'] * $row['product_quantity'];
                                                                    echo '$'.number_format($subtotal,2);
                                                                    ?>
                                                                </td>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="tar">Subtotal</td>
                                                            <td>$<?php echo number_format($order_data['subtotal'], 2); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="tar">(+) Shipping</td>
                                                            <td>$<?php echo number_format($order_data['shipping_cost'], 2); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="tar">(-) Discount</td>
                                                            <td>$<?php echo number_format($order_data['discount'], 2); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="tar">Total</td>
                                                            <td>$<?php echo number_format($order_data['total'], 2); ?></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice-bottom">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-border-0">
                                                    <tbody>
                                                        <td class="w-70 invoice-bottom-payment">
                                                            <h4>Payment Method</h4>
                                                            <p><?php echo $order_data['payment_method']; ?></p>
                                                        </td>
                                                        <td class="w-30 tar invoice-bottom-total-box">
                                                            <h4>Total</h4>
                                                            <p>$<?php echo number_format($order_data['total'], 2); ?></p>
                                                        </td>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="print-button mt_25">
                                <a onclick="printInvoice()" href="javascript:;" class="btn btn-primary"><i class="fas fa-print"></i> Print</a>
                            </div>
                            <script>
                                function printInvoice() {
                                    let body = document.body.innerHTML;
                                    let data = document.getElementById('print_invoice').innerHTML;
                                    document.body.innerHTML = data;
                                    window.print();
                                    document.body.innerHTML = body;
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'layouts/footer.php'; ?>