<?php include 'header.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM wishlists WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
$total = $statement->rowCount();
if($total == 0) {
    header('location: '.BASE_URL.'customer/wishlist');
    exit;
}

$statement = $pdo->prepare("DELETE FROM wishlists WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$_SESSION['success_message'] = 'Product has been removed from wishlist successfully.';
header('location: '.BASE_URL.'customer/wishlist');
exit;