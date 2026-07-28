<?php
require_once 'connect.php';
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];

    // Validate the form data
    $errors = [];
    if (empty($name)) {
        $errors['name'] = 'Nama lengkap harus diisi.';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email tidak valid.';
    }
    if (empty($phone) || !is_numeric($phone)) {
        $errors['phone'] = 'Nomor telepon harus berupa angka.';
    }
    if (empty($address)) {
        $errors['address'] = 'Alamat pengiriman harus diisi.';
    }
    if (empty($payment_method)) {
        $errors['payment_method'] = 'Metode pembayaran harus dipilih.';
    }

    if (empty($_SESSION['cart'])) {
        $errors['cart'] = 'Keranjang belanja kosong.';
    }

    // If there are no validation errors, proceed to process the checkout
    if (empty($errors)) {
        // save the order details to database
        $user_id = $_SESSION['user_id']; // Assuming you have the user ID stored in the session
        $total_amount = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total_amount += $item['price'] * $item['quantity'];
        }

        // sql with pdo
        $sql = "INSERT INTO orders (name, email, phone, address, total_amount, payment_method) VALUES (:name, :email, :phone, :address, :total_amount, :payment_method)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $address,
            ':total_amount' => $total_amount,
            ':payment_method' => $payment_method
        ]);
        // Get the last inserted order ID
        $order_id = $pdo->lastInsertId();

        // Insert order items into the order_items table
        foreach ($_SESSION['cart'] as $product_id => $item) {
            $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':order_id' => $order_id,
                ':product_id' => $product_id,
                ':quantity' => $item['quantity'],
                ':price' => $item['price']
            ]);
        }

        // Clear the cart after successful checkout
        unset($_SESSION['cart']);

        // Redirect to a success page or display a success message with order id parameter
        header('Location: success.php?order_id=' . $order_id);
        exit();
    }

    header('Location: checkout.php?error=1');
}