<?php include "header.php"; 


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



if(!isset($_SESSION['product_id'])) {
    header("location: ".BASE_URL."cart.php");
    exit();
}



if(isset($_POST['form_login'])) {
    try {
        if($_POST['email'] == '') {
            throw new Exception("Email can not be empty");
        }
        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email is invalid");
        }
        if($_POST['password'] == '') {
            throw new Exception("Password can not be empty");
        }

        $q = $pdo->prepare("SELECT * FROM customers WHERE email=? AND status=?");
        $q->execute([$_POST['email'],'Active']);
        $total = $q->rowCount();
        if(!$total) {
            throw new Exception("Email is not found");
        } 
        else {
            $result = $q->fetch(PDO::FETCH_ASSOC);
            if(!password_verify($_POST['password'], $result['password'])) {
                throw new Exception("Password does not match");
            }
        }
        $_SESSION['customer'] = $result;
        $_SESSION['success_message'] = "Login successful!";
        header('location: '.BASE_URL.'checkout');
        exit;
    } catch(Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: '.BASE_URL.'checkout');
        exit;
    }
}



if(isset($_POST['form_logout'])) {
    unset($_SESSION['customer']);
    $_SESSION['success_message'] = "Logout successful!";
    header('location: '.BASE_URL.'checkout');
    exit;
}



if(isset($_POST['form_coupon'])) {
    try {

        if($_POST['code'] == "") {
            throw new Exception("Please enter a coupon code.");
        }

        $statement = $pdo->prepare("SELECT * FROM coupons WHERE code=?");
        $statement->execute([$_POST['code']]);
        $total = $statement->rowCount();
        $coupon_data = $statement->fetch(PDO::FETCH_ASSOC);
        if($total == 0) {
            throw new Exception("Invalid coupon code.");
        }
        if($coupon_data['status'] == 'Inactive') {
            throw new Exception("This coupon code is inactive.");
        }
        if($coupon_data['end_date'] < date('Y-m-d')) {
            throw new Exception("This coupon code has expired.");
        }
        if($coupon_data['start_date'] > date('Y-m-d')) {
            throw new Exception("This coupon code is not yet valid.");
        }

        // Check in orders table for maximum usage 
        // I WILL DO IT LATER

        if($coupon_data['type'] == 'Fixed') {
            $discount = $coupon_data['discount'];
            if($discount > $_SESSION['subtotal']) {
                throw new Exception("Discount amount cannot be greater than subtotal.");
            }
        } else {
            $discount = ($coupon_data['discount']/100) * $_SESSION['subtotal'];
        }

        $_SESSION['discount'] = $discount;
        $_SESSION['code'] = $_POST['code'];

        $_SESSION['success_message'] = "Coupon code applied successfully!";
        header("location: ".BASE_URL."checkout");
        exit();
    } catch(Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location: ".BASE_URL."checkout");
        exit();
    }
}




if(isset($_POST['form_order'])) {
    try {

        if($_POST['name'] == "") {
            throw new Exception("Name can not be empty.");
        }
        if($_POST['email'] == "") {
            throw new Exception("Email can not be empty.");
        }
        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email is invalid.");
        }
        if($_POST['phone'] == "") {
            throw new Exception("Phone can not be empty.");
        }
        if($_POST['address'] == "") {
            throw new Exception("Address can not be empty.");
        }
        if($_POST['shipping_cost'] == "") {
            throw new Exception("Shipping cost can not be empty.");
        }
        if($_POST['payment_method'] == "") {
            throw new Exception("Payment method can not be empty.");
        }

        if(isset($_SESSION['discount'])) {
            $discount = $_SESSION['discount'];
        } else {
            $discount = 0.00;
        }

        $total = $_SESSION['subtotal'] + $_POST['shipping_cost'] - $discount;

        $_SESSION['a_customer_name'] = $_POST['name'];
        $_SESSION['a_customer_email'] = $_POST['email'];
        $_SESSION['a_customer_phone'] = $_POST['phone'];
        $_SESSION['a_customer_address'] = $_POST['address'];
        $_SESSION['a_shipping_cost'] = $_POST['shipping_cost'];
        $_SESSION['a_discount'] = $discount;
        $_SESSION['a_total'] = $total;

        if($_POST['payment_method'] == 'PayPal') {
            try {
                $response = $gateway->purchase(array(
                    'amount' => $total,
                    'currency' => PAYPAL_CURRENCY,
                    'returnUrl' => PAYPAL_RETURN_URL,
                    'cancelUrl' => PAYPAL_CANCEL_URL,
                ))->send();
                if ($response->isRedirect()) {
                    $response->redirect();
                } else {
                    echo $response->getMessage();
                }
            } catch(Exception $e) {
                echo $e->getMessage();
            }
        }
        
        if($_POST['payment_method'] == 'Stripe') 
        {
            \Stripe\Stripe::setApiKey(STRIPE_TEST_SK);
            $response = \Stripe\Checkout\Session::create([
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Products'
                            ],
                            'unit_amount' => $total * 100,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => STRIPE_SUCCESS_URL.'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => STRIPE_CANCEL_URL,
            ]);
            header('location: '.$response->url);
        }
        
        if($_POST['payment_method'] == 'Cash on Delivery') 
        {
            $order_no = 'ORD-'.time().rand(100,999);
            $q = $pdo->prepare("INSERT INTO orders (
                                        order_no, 
                                        customer_name, 
                                        customer_email,
                                        customer_phone,
                                        customer_address,
                                        payment_method,
                                        order_date,
                                        subtotal,
                                        shipping_cost,
                                        coupon_code,
                                        discount,
                                        total,
                                        status
                                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $q->execute([
                            $order_no, 
                            $_SESSION['a_customer_name'],
                            $_SESSION['a_customer_email'],
                            $_SESSION['a_customer_phone'],
                            $_SESSION['a_customer_address'],
                            'Cash on Delivery',
                            date('Y-m-d'),
                            $_SESSION['subtotal'],
                            $_SESSION['a_shipping_cost'],
                            $_SESSION['code'],
                            $_SESSION['a_discount'],
                            $_SESSION['a_total'],
                            'Pending'
                        ]);

            $order_id = $pdo->lastInsertId();

            $i=0;
            $arr_product_id = [];
            foreach($_SESSION['product_id'] as $value) {
                $i++;
                $arr_product_id[$i] = $value;
            }

            $i=0;
            $arr_product_quantity = [];
            foreach($_SESSION['product_quantity'] as $value) {
                $i++;
                $arr_product_quantity[$i] = $value;
            }

            for($i=1;$i<=count($arr_product_id);$i++) {
                $statement = $pdo->prepare("SELECT * FROM products WHERE id=?");
                $statement->execute([$arr_product_id[$i]]);
                $product_data = $statement->fetch(PDO::FETCH_ASSOC);

                $statement = $pdo->prepare("INSERT INTO order_details (order_id,order_no,product_id,product_name,product_price,product_quantity) VALUES (?,?,?,?,?,?)");
                $statement->execute([$order_id,$order_no,$arr_product_id[$i],$product_data['name'],$product_data['sale_price'],$arr_product_quantity[$i]]);

                $new_quantity = $product_data['quantity'] - $arr_product_quantity[$i];
                $new_total_sale = $product_data['total_sale'] + $arr_product_quantity[$i];

                $statement = $pdo->prepare("UPDATE products SET quantity=?, total_sale=? WHERE id=?");
                $statement->execute([$new_quantity,$new_total_sale,$arr_product_id[$i]]);
            }

            // Send email to customer
            $email_message = "<h2>Order Confirmation</h2>";
            $email_message .= "<p>Dear ".$_SESSION['a_customer_name'].",</p>";
            $email_message .= '<p>Thank you for your order. Your order number is <strong>'.$order_no.'</strong>.</p>';
            $email_message .= '<p>Order Details:</p>';
            $email_message .= '<table border="1" cellpadding="10" cellspacing="0">';
            $email_message .= '<tr><th>Product Name</th><th>Quantity</th><th>Price</th></tr>';
            for($i=1;$i<=count($arr_product_id);$i++) {
                $statement = $pdo->prepare("SELECT * FROM products WHERE id=?");
                $statement->execute([$arr_product_id[$i]]);
                $product_data = $statement->fetch(PDO::FETCH_ASSOC);
                $email_message .= '<tr>';
                $email_message .= '<td>'.$product_data['name'].'</td>';
                $email_message .= '<td>'.$arr_product_quantity[$i].'</td>';
                $email_message .= '<td>$'.$product_data['sale_price'].'</td>';
                $email_message .= '</tr>';
            }
            $email_message .= '</table>';
            $email_message .= '<p>Subtotal: $'.$_SESSION['subtotal'].'</p>';
            $email_message .= '<p>Shipping Cost: $'.$_SESSION['a_shipping_cost'].'</p>';
            $email_message .= '<p>Coupon Code: '.$_SESSION['code'].'</p>';
            $email_message .= '<p>Discount: $'.$_SESSION['a_discount'].'</p>';
            $email_message .= '<p>Total: $'.$_SESSION['a_total'].'</p>';
            $email_message .= '<p>Payment Method: Cash on Delivery</p>';
            $email_message .= '<p>Payment Status: Pending</p>';
            $email_message .= '<p>Thank you for shopping with us!</p>';
            $email_message .= '<p>Best Regards,</p>';
            $email_message .= '<p>Your Company Name</p>';


            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->SMTPSecure = SMTP_ENCRYPTION;
            $mail->Port = SMTP_PORT;
            $mail->setFrom(SMTP_FROM);
            $mail->addAddress($_SESSION['a_customer_email']);
            $mail->isHTML(true);
            $mail->Subject = 'Order Summary - '.$order_no;
            $mail->Body = $email_message;
            $mail->send();

            $_SESSION['success_message'] = "Payment is pending for cash on delivery. Please check your email for order status and detail.";

            unset($_SESSION['product_id']);
            unset($_SESSION['product_quantity']);
            unset($_SESSION['subtotal']);
            unset($_SESSION['a_shipping_cost']);
            unset($_SESSION['code']);
            unset($_SESSION['discount']);
            unset($_SESSION['a_discount']);
            unset($_SESSION['a_total']);
            unset($_SESSION['a_customer_name']);
            unset($_SESSION['a_customer_email']);
            unset($_SESSION['a_customer_phone']);
            unset($_SESSION['a_customer_address']);

            header('location: '.BASE_URL);
            exit;    
        }

    } catch(Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("location: ".BASE_URL."checkout");
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
            <li>Cart</li>
            <li class="ml_10 mr_10">
                <i class="fas fa-chevron-right"></i>
            </li>
            <li>Checkout</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="checkout-page mt-100">
        <div class="container">
            <div class="checkout-page-wrapper">
                <div class="row">
                    <div class="col-xl-9 col-lg-8 col-md-12 col-12">
                        <div class="section-header mb-3">
                            <h2 class="section-heading">Check out</h2>
                        </div>

                        <?php if(!isset($_SESSION['customer'])): ?>
                        <form action="" method="post">
                        <div class="shipping-address-area">
                            <div class="mb_30">
                                <a href="javascript:void;" onclick="toggleLoginForm()" style="color:#F0686E;text-decoration:underline;">Existing Customer? Login Here</a>
                            </div>
                            <div id="loginForm" style="display:none;">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <input type="text" name="email" class="form-control" placeholder="Email Address">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="password" name="password" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <button type="submit" class="btn btn-primary btn-sm" name="form_login">Login</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                        <script>
                        function toggleLoginForm() {
                            const form = document.getElementById('loginForm');
                            form.style.display = form.style.display === 'none' ? 'block' : 'none';
                        }
                        </script>
                        <?php else: ?>
                            <form action="" method="post">
                                <div class="shipping-address-area">
                                    You are logged in as <strong><?php echo $_SESSION['customer']['name']; ?></strong><br>
                                    <button type="submit" name="form_logout" style="color:red;text-decoration:underline;background:#fff;">Logout</button>
                                </div>
                            </form>
                        <?php endif; ?>
                            

                        <form action="" method="post">
                        <div class="shipping-address-area">
                            <h2 class="shipping-address-heading pb-1 mb_20">Customer Information</h2>
                            <div class="shipping-address-form-wrapper">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" placeholder="Name" name="name" value="<?php if(isset($_SESSION['customer'])) { echo $_SESSION['customer']['name']; } ?>">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" placeholder="Email" name="email" value="<?php if(isset($_SESSION['customer'])) { echo $_SESSION['customer']['email']; } ?>">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" placeholder="Phone" name="phone" value="<?php if(isset($_SESSION['customer'])) { echo $_SESSION['customer']['phone']; } ?>">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" placeholder="Address" name="address" value="<?php if(isset($_SESSION['customer'])) { echo $_SESSION['customer']['address']; } ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="shipping-address-area billing-area">
                            <h2 class="shipping-address-heading pb-1 mb_20">Payment</h2>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <select name="shipping_cost" id="area-select" class="form-select">
                                        <option value="">Select Area</option>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM areas");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            ?>
                                            <option value="<?php echo $row['charge']; ?>"><?php echo $row['name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <select name="payment_method" class="form-select" onchange="togglePaymentFields()">
                                        <option value="">Select Payment Method</option>
                                        <option value="Cash on Delivery">Cash on Delivery</option>
                                        <option value="PayPal">PayPal</option>
                                        <option value="Stripe">Stripe</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <button type="submit" class="checkout-page-btn btn-primary mt_20" name="form_order">CONFIRM ORDER</button>
                                    <div class="mt_20">
                                        <a href="<?php echo BASE_URL; ?>cart.php" style="color:#F0686E;text-decoration:underline;">Back to Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                        <div class="cart-total-area checkout-summary-area">
                            <h3 class="d-none d-lg-block mb-0 text-center heading_24 mb-4">Order summary</h4>

                            <?php
                            $i=0;
                            $arr_product_id = [];
                            foreach($_SESSION['product_id'] as $value) {
                                $i++;
                                $arr_product_id[$i] = $value;
                            }

                            $i=0;
                            $arr_product_quantity = [];
                            foreach($_SESSION['product_quantity'] as $value) {
                                $i++;
                                $arr_product_quantity[$i] = $value;
                            }
                            ?>

                            <?php $subtotal = 0; ?>

                            <?php for($i=1;$i<=count($arr_product_id);$i++): ?>
                                <?php
                                    $statement = $pdo->prepare("SELECT p.*,
                                                            pc.name as category_name 
                                                            FROM products p
                                                            JOIN product_categories pc
                                                            ON p.product_category_id = pc.id
                                                            WHERE p.id=?");
                                    $statement->execute([$arr_product_id[$i]]);
                                    $product_data = $statement->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <div class="minicart-item d-flex">
                                    <div class="mini-img-wrapper">
                                        <img class="mini-img" src="<?php echo BASE_URL; ?>uploads/<?php echo $product_data['featured_photo']; ?>" alt="img">
                                    </div>
                                    <div class="product-info">
                                        <h2 class="product-title"><a href="<?php echo BASE_URL; ?>product/<?php echo $product_data['slug']; ?>"><?php echo $product_data['name']; ?></a></h2>
                                        <p class="product-vendor">$<?php echo $product_data['sale_price']; ?> x <?php echo $arr_product_quantity[$i]; ?></p>
                                    </div>
                                </div>
                                <?php
                                $temp = $product_data['sale_price'] * $arr_product_quantity[$i];
                                $subtotal += $temp;
                                ?>
                            <?php endfor; ?>
                            <?php
                            $_SESSION['subtotal'] = $subtotal;
                            ?>

                            <div class="cart-total-box mt-4 bg-transparent p-0">
                                <div class="subtotal-item subtotal-box">
                                    <h4 class="subtotal-title">Subtotals:</h4>
                                    <p class="subtotal-value">$<span id="subtotal-amount"></span></p>
                                </div>
                                <div class="subtotal-item shipping-box">
                                    <h4 class="subtotal-title">Shipping:</h4>
                                    <p class="subtotal-value">(+) $<span id="shipping-amount">0.00</span></p>
                                </div>
                                <div class="subtotal-item discount-box">
                                    <h4 class="subtotal-title">
                                        Discount:
                                        <?php if(isset($_SESSION['discount']) && isset($_SESSION['code'])): ?>
                                        <br><span style="font-size:12px;">Applied: <?php echo $_SESSION['code']; ?></span><br>
                                        <a href="<?php echo BASE_URL; ?>coupon-remove.php?code=<?php echo $_SESSION['code']; ?>" style="font-size:12px;color:red;text-decoration:underline;">Remove</a>
                                        <?php endif; ?>
                                    </h4>
                                    <p class="subtotal-value">(-) $<span id="discount-amount"></span></p>
                                </div>
                                <hr />
                                <div class="subtotal-item total-box">
                                    <h4 class="subtotal-title">Total:</h4>
                                    <p class="subtotal-value">$<span id="total-amount">260.00</span></p>
                                </div>
                                

                                <?php if(!isset($_SESSION['discount'])): ?>
                                <div class="mt-4 checkout-promo-code">
                                    <form action="" method="post">
                                        <input class="input-promo-code" type="text" placeholder="Coupon code" name="code">
                                        <button type="submit" class="btn-apply-code position-relative btn-primary text-uppercase mt-3" name="form_coupon">
                                            Apply Promo Code
                                        </button>
                                    </form>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>            
</main>

<?php
if(isset($_SESSION['discount'])) {
    $discount_now = $_SESSION['discount'];
} else {
    $discount_now = 0.00;
}
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    const areaSelect = document.getElementById('area-select');
    const subtotalAmount = document.getElementById('subtotal-amount');
    const shippingAmount = document.getElementById('shipping-amount');
    const discountAmount = document.getElementById('discount-amount');
    const totalAmount = document.getElementById('total-amount');
    
    // Initial values
    const subtotal = <?php echo $_SESSION['subtotal'] ?>;
    const discount = <?php echo $discount_now ?>;
    let shipping = 0.00;
    let total = subtotal - discount + shipping;
    
    // Update the display
    function updateTotals() {
        subtotalAmount.textContent = subtotal.toFixed(2);
        shippingAmount.textContent = shipping.toFixed(2);
        discountAmount.textContent = discount.toFixed(2);
        totalAmount.textContent = total.toFixed(2);
    }
    
    // Handle area selection change
    areaSelect.addEventListener('change', function() {
        // Get selected shipping cost
        shipping = this.value ? parseFloat(this.value) : 0.00;
        
        // Calculate new total
        total = subtotal - discount + shipping;
        
        // Update the display
        updateTotals();
    });
    
    // Initialize on page load
    updateTotals();
});
</script>

<?php include "footer.php"; ?>