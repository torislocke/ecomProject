<?php include 'layouts/top.php'; ?>


<?php
if ($_GET['email'] == '' || $_GET['token'] == '') {
    header('location: ' . ADMIN_URL . 'login');
    exit();
}

$statement = $pdo->prepare("SELECT * FROM admins WHERE email=? AND token=?");
$statement->execute([$_GET['email'], $_GET['token']]);
$total = $statement->rowCount();
if ($total == 0) {
    header('location: ' . ADMIN_URL . 'login');
    exit();
}

// Update the customer's status to 'Active'
$statement = $pdo->prepare("UPDATE admins SET status=?, token=? WHERE email=? AND token=?");
$statement->execute(['Active', '', $_GET['email'], $_GET['token']]);

$_SESSION['success_message'] = "Your account has been activated successfully. You can now log in.";
header('location: ' . ADMIN_URL . 'login');
exit();
