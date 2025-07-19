<?php
ob_start();
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include "config/config.php";
include "config/config_payment.php";
if (array_key_exists('paymentId', $_GET) && array_key_exists('PayerID', $_GET)) {
    $transaction = $gateway->completePurchase(array(
        'payer_id' => $_GET['PayerID'],
        'transactionReference' => $_GET['paymentId'],
    ));
    $response = $transaction->send();
    if ($response->isSuccessful()) {
        $arr_body = $response->getData();
 
        $payment_id = $arr_body['id'];
        $payer_id = $arr_body['payer']['payer_info']['payer_id'];
        $payer_email = $arr_body['payer']['payer_info']['email'];
        $amount = $arr_body['transactions'][0]['amount']['total'];
        $currency = PAYPAL_CURRENCY;
        $payment_status = $arr_body['state'];

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
                        'PayPal',
                        date('Y-m-d'),
                        $_SESSION['subtotal'],
                        $_SESSION['a_shipping_cost'],
                        $_SESSION['code'],
                        $_SESSION['a_discount'],
                        $_SESSION['a_total'],
                        'Paid'
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
        $email_message .= '<p>Payment Method: PayPal</p>';
        $email_message .= '<p>Payment Status: Paid</p>';
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

        $_SESSION['success_message'] = "Payment is successful. Please check your email for order detail.";

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
    } else {
        $_SESSION['error_message'] = $response->getMessage();
        header('location: '.BASE_URL.'checkout');
        exit;
    }
} else {
    header('location: '.BASE_URL.'checkout');
    exit;
}