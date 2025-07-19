<?php include "header.php"; ?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<?php
if(isset($_POST['form_send_mail'])) {
    try {

        if($_POST['name'] == '') {
            throw new Exception('Name cannot be empty');
        }
        if($_POST['email'] == '') {
            throw new Exception('Email cannot be empty');
        }
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format');
        }
        if($_POST['phone'] == '') {
            throw new Exception('Phone number cannot be empty');
        }
        if($_POST['message'] == '') {
            throw new Exception('Message cannot be empty');
        }
        
        $email_message = "<h3>Visitor Information</h3>";
        $email_message .= "<p><strong>Name:</strong><br>" . $_POST['name']. "</p>";
        $email_message .= "<p><strong>Email:</strong><br>" . $_POST['email']. "</p>";
        $email_message .= "<p><strong>Phone:</strong><br>" . $_POST['phone']. "</p>";
        $email_message .= "<p><strong>Message:</strong><br>" . nl2br($_POST['message']). "</p>";

        $statement = $pdo->prepare("SELECT * FROM admins WHERE id=?");
        $statement->execute([1]);
        $admin_data = $statement->fetch(PDO::FETCH_ASSOC);
        

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION;
        $mail->Port = SMTP_PORT;
        $mail->setFrom(SMTP_FROM);
        $mail->addAddress($admin_data['email']);
        $mail->isHTML(true);
        $mail->Subject = 'Contact Form Message';
        $mail->Body = $email_message;
        $mail->send();

        $_SESSION['success_message'] = 'Email has been sent successfully.';
        header('location: '.BASE_URL.'contact.php');
        exit;


    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: '.BASE_URL.'contact.php');
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
            <li>Contact US</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="contact-page">

        <!-- contact box start -->
        <div class="contact-box mt-100">
            <div class="contact-box-wrapper">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope" style="font-size: 40px;"></i>
                                </div>
                                <div class="contact-details">
                                    <h2 class="contact-title">Mail Address</h2>
                                    <a class="contact-info" href="mailto:info@example.com">info@example.com</a>
                                    <a class="contact-info" href="mailto:info2@example.com">info2@example.com</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-location-arrow" style="font-size: 40px;"></i>
                                </div>
                                <div class="contact-details">
                                    <h2 class="contact-title">Office Location</h2>
                                    <p class="contact-info">Road 01, Test City, State, Country, 11111</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-phone" style="font-size: 40px;"></i>
                                </div>
                                <div class="contact-details">
                                    <h2 class="contact-title">Phone Number</h2>
                                    <a class="contact-info" href="tel:(111) 000-0000">(111) 000-0000</a>
                                    <a class="contact-info" href="tel:(111) 111-1111">(111) 111-1111</a>
                                </div>
                            </div>
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>
        <!-- contact box end -->

        <!-- about banner start -->
        <div class="contact-form-section mt-100">
            <div class="container">
                <div class="contact-form-area">
                    <div class="section-header mb-4">
                        <h2 class="section-heading">Drop us a line</h2>
                        <p class="section-subheading">We would like to hear from you.</p>
                    </div>
                    <div class="contact-form--wrapper">
                        <form action="" class="contact-form" method="post">
                            <div class="row">
                                <div class="col-lg-4 col-md-12">
                                    <fieldset>
                                        <input type="text" name="name" placeholder="Full Name *">
                                    </fieldset>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <fieldset>
                                        <input type="email" name="email" placeholder="Email Address *">
                                    </fieldset>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <fieldset>
                                        <input type="text" name="phone" placeholder="Phone Number *">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <fieldset>
                                        <textarea cols="20" rows="6" name="message" placeholder="Message *"></textarea>
                                    </fieldset>
                                    <button type="submit" class="position-relative review-submit-btn contact-submit-btn" name="form_send_mail">SEND MESSAGE</button>
                                </div>
                            </div>                                    
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- about banner end -->
    </div>            
</main>

<?php include "footer.php"; ?>