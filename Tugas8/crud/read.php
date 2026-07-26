<?php
require_once '../connect.php';

//read data from products table
$sql = "SELECT * FROM products";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

//display data in table
echo "<table border='1'>";
echo "<tr>";
echo "<th>ID</th>";
echo "<th>Name</th>";
echo "<th>Price</th>";
echo "<th>Description</th>";
echo "<th>Image</th>";
echo "<th>Stock</th>";
echo "<th>Category</th>";
echo "<th>Action</th>";
echo "</tr>";
foreach ($products as $product) {
    echo "<tr>";
    echo "<td>" . $product['id'] . "</td>";
    echo "<td>" . $product['name'] . "</td>";
    echo "<td>" . $product['price'] . "</td>";
    echo "<td>" . $product['description'] . "</td>";
    echo "<td><img src='" . $product['image'] . "' width='100'></td>";
    echo "<td>" . $product['stock'] . "</td>";
    echo "<td>" . $product['category'] . "</td>";
    echo "<td><a href='update.php?id=" . $product['id'] . "'>Edit</a> | <a href='delete.php?id=" . $product['id'] . "'>Delete</a></td>";
    echo "</tr>";
}
echo "</table>";