<?php
$name   = trim($_POST['coffee_name']);
$size1  = trim($_POST['size_1']);
$price1 = floatval($_POST['price_1']);
$size2  = trim($_POST['size_2']);
$price2 = floatval($_POST['price_2']);

$uploadDir = '../uploads/';
$imageName = basename($_FILES['coffee_image']['name']);
$imagePath = $uploadDir . time() . '_' . $imageName; // Timestamp prefix for uniqueness

$dbhost = 'localhost';
$dbname = 'ecomproject';
$dbuser = 'root';
$dbpass = '';

// Validate and move uploaded file
if (move_uploaded_file($_FILES['coffee_image']['tmp_name'], $imagePath)) {
 
        try {
            $pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
       
           $pdo->beginTransaction();  // Start transaction
        
        $stmt = $pdo->prepare("INSERT INTO coffee_types (name, image_path) VALUES (?, ?)");
        $stmt->execute([$name, $imagePath]);
        $coffeeId = $pdo->lastInsertId();

        $variantStmt = $pdo->prepare("INSERT INTO coffee_variants (coffee_id, size, price) VALUES (?, ?, ?)");
        $variantStmt->execute([$coffeeId, $size1, $price1]);
        $variantStmt->execute([$coffeeId, $size2, $price2]);

    
        echo "Coffee added with image!";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Image upload failed.";
}
?>

