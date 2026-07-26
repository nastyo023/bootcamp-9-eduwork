<?php
require_once '../connect.php';

//delete data from products table based on id
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL statement
    $sql = "DELETE FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':id', $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Product deleted successfully.";
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting product.";
    }
}