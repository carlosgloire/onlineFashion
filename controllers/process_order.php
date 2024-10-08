<?php
session_start();
require_once('../database/db.php');

function notconnected(){
    if (!isset($_SESSION['user'])) {
        // Redirect to the login page if not logged in
        header("Location: ../templates/login.php");
        exit();
    }
}
notconnected();

$user_id = $_SESSION['userID'];

// Check if user_id exists in the users table
$query = $db->prepare('SELECT * FROM users WHERE user_id = ?');
$query->execute([$user_id]);
$user = $query->fetch();

if (!$user) {
    die("User ID does not exist in the database.");
}

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $order_total = 0;

    // Insert a new order record
    $order_query = $db->prepare('INSERT INTO orders (user_id, order_date, status) VALUES (?, NOW(), "pending")');
    $order_query->execute([$user_id]);
    $order_id = $db->lastInsertId(); // Get the ID of the newly created order

    // Insert a new order record for user
    $order_query = $db->prepare('INSERT INTO order_user (user_id, order_date, status) VALUES (?, NOW(), "pending")');
    $order_query->execute([$user_id]);
    $order_id = $db->lastInsertId(); 

    // Insert each product in the order
    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['product_id'];
        $quantity = isset($item['quantity']) ? $item['quantity'] : 0;
        $sizes = isset($item['sizes']) ? implode(', ', $item['sizes']) : '';

        // Get product price
        $product_query = $db->prepare('SELECT price FROM products WHERE product_id = ?');
        $product_query->execute([$product_id]);
        $product = $product_query->fetch();

        if ($product) {
            $total_price = $product['price'] * $quantity;
            $order_total += $total_price;

            // Insert the product into the order_items table
            $item_query = $db->prepare('INSERT INTO order_item (order_id, product_id, quantity, total_price,  size) VALUES ( ?, ?, ?, ?, ?)');
            $item_query->execute([$order_id, $product_id, $quantity, $total_price,  $sizes]);

            // Insert the product into the order_items table for a user
            $item_query = $db->prepare('INSERT INTO order_item_user (order_id, product_id, quantity, total_price,  size) VALUES ( ?, ?, ?, ?, ?)');
            $item_query->execute([$order_id, $product_id, $quantity, $total_price, $sizes]);
        }
    }

    // Update the total order amount
    $update_order_query = $db->prepare('UPDATE orders SET total_amount = ? WHERE order_id = ?');
    $update_order_query->execute([$order_total, $order_id]);

    // Update the total order user amount
    $update_order_user_query = $db->prepare('UPDATE order_user SET total_amount = ? WHERE order_id = ?');
    $update_order_user_query->execute([$order_total, $order_id]);

    // Store order ID in session to be used on the payment page
    $_SESSION['order_id'] = $order_id;

    // Redirect to the payment page
    header('Location: ../templates/payment.php');
    exit();
} else {
    // Redirect to the cart page if the cart is empty
    header('Location: ../templates/cart.php');
    exit();
}
?>
