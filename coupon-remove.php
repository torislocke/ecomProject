<?php include "header.php"; ?>

<?php
unset($_SESSION['discount']);
unset($_SESSION['code']);
$_SESSION['success_message'] = 'Coupon is removed successfully!';
header("location: ".BASE_URL."checkout");
exit();