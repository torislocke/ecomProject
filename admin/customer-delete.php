<?php include 'layouts/top.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM customers WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
$total = $statement->rowCount();
if($total == 0) {
    header('location: '.ADMIN_URL.'customer-view.php');
    exit;
}

$statement = $pdo->prepare("DELETE FROM customers WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$_SESSION['success_message'] = 'Customer has been deleted successfully.';
header('location: '.ADMIN_URL.'customer-view.php');
exit;