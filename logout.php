<?php
include "header.php";
unset($_SESSION['customer']);
$_SESSION['success_message'] = "Logout successful!";
header('location: '.BASE_URL.'login');
exit;