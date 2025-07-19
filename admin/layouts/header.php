<?php
ob_start();
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
$statement = $pdo->prepare("SELECT * FROM settings WHERE id=?");
$statement->execute([1]);
$setting_data = $statement->fetch(PDO::FETCH_ASSOC);

$sessionTimeout = 1200; // 20 minutes
if(isset($_SESSION['last_activity_admin']) && (time() - $_SESSION['last_activity_admin']) > $sessionTimeout) {
    unset($_SESSION['admin']);
    unset($_SESSION['last_activity_admin']);
    $_SESSION['error_message'] = 'Your session has expired due to inactivity. Please log in again.';
    header('location: '.ADMIN_URL.'login.php');
    exit;
}
$_SESSION['last_activity_admin'] = time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>uploads/<?php echo $setting_data['favicon']; ?>">

    <title>Admin Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/font_awesome_5_free.min.css">
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/duotone-dark.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/iziToast.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/fontawesome-iconpicker.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/bootstrap4-toggle.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/components.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/air-datepicker.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/spacing.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/custom.css">

    <script src="<?php echo BASE_URL; ?>dist-admin/js/jquery-3.7.0.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/popper.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/tooltip.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/jquery.nicescroll.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/moment.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/stisla.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/jscolor.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/bootstrap-tagsinput.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/iziToast.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/fontawesome-iconpicker.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/air-datepicker.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/tinymce/tinymce.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/bootstrap4-toggle.min.js"></script>
</head>

<body>
<div id="app">
    <div class="main-wrapper">