<!-- connect to database -->
<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "bootcamp_9"; 
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$database;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}