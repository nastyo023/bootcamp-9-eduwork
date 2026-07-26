<?php
include '../connect.php';
// Insert data into products table (name, price, description, image, stock, category)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];

    // Prepare the SQL statement
    $sql = "INSERT INTO products (name, price, description, image, stock, category) VALUES (:name, :price, :description, :image, :stock, :category)";
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':category', $category);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Product created successfully.";
        header("Location: index.php");
        exit();
    } else {
        echo "Error creating product.";
    }
}
?>