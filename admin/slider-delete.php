<?php include 'layouts/top.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM sliders WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
$total = $statement->rowCount();
if($total == 0) {
    header('location: '.ADMIN_URL.'slider-view.php');
    exit;
}

unlink('../uploads/'.$result['photo1']);
unlink('../uploads/'.$result['photo2']);

$statement = $pdo->prepare("DELETE FROM sliders WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$_SESSION['success_message'] = 'Slider has been deleted successfully.';
header('location: '.ADMIN_URL.'slider-view.php');
exit;