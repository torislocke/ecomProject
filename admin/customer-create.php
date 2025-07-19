<?php include 'layouts/top.php'; ?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<?php
if(isset($_POST['form1'])) {
    try {

        if($_POST['name'] == '') {
            throw new Exception('Name can not be empty');
        }
        if($_POST['email'] == '') {
            throw new Exception('Email can not be empty');
        }
        // email validation check
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email is not valid');
        }
        // duplicate email check
        $statement = $pdo->prepare("SELECT * FROM customers WHERE email=?");
        $statement->execute([$_POST['email']]);
        $total = $statement->rowCount();
        if($total) {
            throw new Exception('Email already exists');
        }
        if($_POST['phone'] == '') {
            throw new Exception('Phone can not be empty');
        }
        if($_POST['address'] == '') {
            throw new Exception('Address can not be empty');
        }

        if($_POST['password'] == '') {
            throw new Exception('Password can not be empty');
        }

        if($_POST['confirm_password'] == '') {
            throw new Exception('Confirm Password can not be empty');
        }

        if($_POST['password'] != $_POST['confirm_password']) {
            throw new Exception('Passwords do not match');
        }

        $final_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $statement = $pdo->prepare("INSERT INTO customers (name,email,phone,address,password,token,status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $statement->execute([$_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address'], $final_password, '', $_POST['status']]);

        // Send email to the customer

        $email_message = "Dear ".$_POST['name'].",<br><br>";
        $email_message .= "Your account has been created successfully.<br>";
        $email_message .= "Here are your login details:<br>";
        $email_message .= "Login URL: <a href='".BASE_URL."login'>".BASE_URL."login</a><br>";
        $email_message .= "Email: ".$_POST['email']."<br>";
        $email_message .= "Password: ".$_POST['password']."<br><br>";

        $mail = new PHPMailer(true);
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
        $mail->Subject = 'Your Account is Created';
        $mail->Body = $email_message;
        $mail->send();
        

        $_SESSION['success_message'] = 'Customer has been created successfully.';
        header('location: '.ADMIN_URL.'customer-view.php');
        exit;


    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: '.ADMIN_URL.'customer-create.php');
        exit;
    }
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Create Customer</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>customer-view.php" class="btn btn-primary"><i class="fas fa-eye"></i> View All</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Name *</label>
                                            <input type="text" class="form-control" name="name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Email *</label>
                                            <input type="text" class="form-control" name="email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Phone *</label>
                                            <input type="text" class="form-control" name="phone">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Address *</label>
                                            <input type="text" class="form-control" name="address">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Password *</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Confirm Password *</label>
                                            <input type="password" class="form-control" name="confirm_password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Status *</label>
                                            <select name="status" class="form-select">
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="form1">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'layouts/footer.php'; ?>