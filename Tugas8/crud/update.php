<?php
require_once '../connect.php';

//update data in products table (name, price, description, image, stock, category) based on id
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];

    // Prepare the SQL statement
    $sql = "UPDATE products SET name = :name, price = :price, description = :description, image = :image, stock = :stock, category = :category WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':category', $category);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Product updated successfully.";
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating product.";
    }
}