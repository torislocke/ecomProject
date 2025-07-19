<?php include "header.php"; ?>

<?php
if(isset($_GET['token']) && isset($_GET['email'])) {
    $token = $_GET['token'];
    $email = $_GET['email'];

    $statement = $pdo->prepare("SELECT * FROM subscribers WHERE email=? AND token=?");
    $statement->execute([$email, $token]);
    $subscriber = $statement->fetch(PDO::FETCH_ASSOC);

    if($subscriber) {
        $statement = $pdo->prepare("UPDATE subscribers SET status=?, token=? WHERE email=? AND token=?");
        $statement->execute(['Active', '', $email, $token]);
        $_SESSION['success_message'] = "Your subscription has been confirmed.";
    } else {
        $_SESSION['error_message'] = "Invalid subscription confirmation link.";
    }

    header("location: " . BASE_URL);
    exit();
} else {
    $_SESSION['error_message'] = "Invalid request.";
    header("location: " . BASE_URL);
    exit();
}
?>