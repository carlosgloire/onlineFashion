<?php
session_start();
require_once('../database/db.php');

if (!isset($_GET['order_id'])) {
    header('Location: cart.php');
    exit();
}

$order_id = $_GET['order_id'];

$amount = isset($_GET['amount']) ? $_GET['amount'] : 0;  // Set default value or handle gracefully


$payment_status = "completed"; // Set the payment status as completed

// Store payment details in the payment table
$payment_query = $db->prepare('INSERT INTO payment (order_id, payment_date, payment_method, status, amount) VALUES (?, NOW(), ?, ?, ?)');
$payment_query->execute([$order_id, 'Flutterwave', $payment_status, $amount]);

// Update order status to 'completed'
$update_order_query = $db->prepare('UPDATE orders SET status = "completed" WHERE order_id = ?');
$update_order_query->execute([$order_id]);

// Update order status to 'completed'
$update_order_query = $db->prepare('UPDATE order_user SET status = "completed" WHERE order_id = ?');
$update_order_query->execute([$order_id]);

// Retrieve all items in the order
$order_items_query = $db->prepare('SELECT product_id, quantity FROM order_item WHERE order_id = ?');
$order_items_query->execute([$order_id]);
$order_items = $order_items_query->fetchAll(PDO::FETCH_ASSOC);

// Update the stock for each shoe
foreach ($order_items as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];

    // Subtract the quantity from the stock
    $update_stock_query = $db->prepare('UPDATE products SET stock = stock - ? WHERE product_id = ?');
    $update_stock_query->execute([$quantity, $product_id]);
}

// Clear the session order ID
unset($_SESSION['order_id']);

// Clear the cart after successful payment
unset($_SESSION['cart']);

// Redirect to payment success page
header('Location: index.php');

exit();
?>
