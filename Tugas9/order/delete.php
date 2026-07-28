<?php
session_start();
require_once '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;

    if ($order_id <= 0) {
        header('Location: index.php');
        exit();
    }

    try {
        // Delete order items first
        $sql_delete_items = "DELETE FROM order_items WHERE order_id = ?";
        $stmt_delete_items = $pdo->prepare($sql_delete_items);
        $stmt_delete_items->execute([$order_id]);

        // Then delete the order
        $sql_delete_order = "DELETE FROM orders WHERE id = ?";
        $stmt_delete_order = $pdo->prepare($sql_delete_order);
        $stmt_delete_order->execute([$order_id]);

        // Redirect back to order list
        header('Location: index.php');
        exit();
    } catch (\PDOException $e) {
        // Log error and redirect
        error_log('Error deleting order: ' . $e->getMessage());
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>