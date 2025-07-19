<?php
$dbhost = 'localhost';
$dbname = 'ecommerce_project';
$dbuser = 'root';
$dbpass = '';
try {
    $pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch( PDOException $exception ) {
    echo "Connection error :" . $exception->getMessage();
}
define("BASE_URL", "http://localhost/ecommerce_project/");
define("ADMIN_URL", BASE_URL."admin/");

define("SMTP_HOST", "smtp.gmail.com");
define("SMTP_PORT", "587");
define("SMTP_USERNAME", "torislocke@gmail.com");
define("SMTP_PASSWORD", "pqwkeilbobqoptwg");
define("SMTP_ENCRYPTION", "tls");
define("SMTP_FROM", "torislocke@gmail.com");
