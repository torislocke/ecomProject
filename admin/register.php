<?php include 'layouts/top.php'; ?>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<?php
if (isset($_POST['form_register'])) {
    try {

        if ($_POST['name'] == '') {
            throw new Exception("Name is required.");
        }

        if ($_POST['email'] == '') {
            throw new Exception("Email is required.");
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }

        $statement = $pdo->prepare("SELECT * FROM admins WHERE email=?");
        $statement->execute([$_POST['email']]);
        $total = $statement->rowCount();
        if ($total) {
            throw new Exception("Email already exists.");
        }

        if ($_POST['password'] == '') {
            throw new Exception("Password is required.");
        }

        if ($_POST['confirm_password'] == '') {
            throw new Exception("Confirm Password is required.");
        }

        if ($_POST['password'] != $_POST['confirm_password']) {
            throw new Exception("Password and Confirm Password do not match.");
        }

        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(12));

        $statement = $pdo->prepare("INSERT INTO admins (name, email, password, token, status) VALUES (?, ?, ?, ?, ?)");
        $statement->execute([$_POST['name'], $_POST['email'], $password, $token, 'Inactive']);

        // Send activation email
        $email_message = "Please click on the following link in order to activate the account: <br>";
        $email_message .= '<a href="' . ADMIN_URL . 'register_verify.php?email=' . $_POST['email'] . '&token=' . $token . '">Click on this Link</a>';

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->SMTPSecure = SMTP_ENCRYPTION;
            $mail->Port = SMTP_PORT;
            $mail->setFrom(SMTP_FROM);
            $mail->addAddress($_POST['email']);
            $mail->isHTML(true);
            $mail->Subject = 'Account Activation';
            $mail->Body = $email_message;
            $mail->send();
            $success_message = 'Please check your email and follow the steps.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        $_SESSION['success_message'] = "Registration successful. Please check your email to activate your account.";
        header("location: " . ADMIN_URL . "login");
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header("location: " . ADMIN_URL . "register");
        exit;
    }
}
?>

<!-- breadcrumb start -->
<div class="breadcrumb">
    <div class="container">
        <ul class="list-unstyled d-flex align-items-center m-0">
            <li><a href="<?php echo ADMIN_URL; ?>">Home</a></li>
            <li class="ml_10 mr_10">
                <i class="fas fa-chevron-right"></i>
            </li>
            <li>Register</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<section class="section">
    <div class="container container-login">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="card card-primary border-box">
                    <div class="card-header card-header-auth">
                        <h2 class="section-heading text-center">Register</h2>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <fieldset>
                                <label class="label">Name</label>
                                <input type="text" name="name">
                            </fieldset>
                        </div>
                        <div class="col-12">
                            <fieldset>
                                <label class="label">Email address</label>
                                <input type="email" name="email">
                            </fieldset>
                        </div>
                        <div class="col-12">
                            <fieldset>
                                <label class="label">Photo</label>
                                <input type="email" name="photo>
                            </fieldset>
                        </div>
                        <div class="col-12">
                            <fieldset>
                                <label class="label">Password</label>
                                <input type="password" name="password">
                            </fieldset>
                        </div>
                        <div class="col-12">
                            <fieldset>
                                <label class="label">Confirm Password</label>
                                <input type="password" name="confirm_password">
                            </fieldset>
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn-primary d-block mt-3 btn-signin" name="form_register">CREATE ACCOUNT</button>
                            <a href="<?php echo ADMIN_URL; ?>login" class="btn-secondary mt-2 btn-signin">GO TO LOGIN PAGE</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            </main>

            <?php include 'layouts/footer.php'; ?>