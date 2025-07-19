<?php include 'layouts/top.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM product_categories WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
$total = $statement->rowCount();
if($total == 0) {
    header('location: '.ADMIN_URL.'product-category-view.php');
    exit;
}

unlink('../uploads/'.$result['photo']);

$statement = $pdo->prepare("DELETE FROM product_categories WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$_SESSION['success_message'] = 'Product category has been deleted successfully.';
header('location: '.ADMIN_URL.'product-category-view.php');
exit;