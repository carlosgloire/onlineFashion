<?php
session_start();
require_once('../database/db.php');
if (isset($_POST['ajouter_panier'])) {
    $product_id = $_POST['product_id'];
    $sizes = isset($_POST['selected_sizes']) ? json_decode($_POST['selected_sizes'], true) : [];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['sizes'] = array_unique(array_merge($_SESSION['cart'][$product_id]['sizes'], $sizes));
    } else {
        $_SESSION['cart'][$product_id] = [
            'product_id' => $product_id,
            'sizes' => $sizes,
            'quantity' => 1
        ];
    }

    echo '<script>alert("Product added to cart successfully!");</script>';
    echo '<script>window.location.href="../templates/cart.php";</script>';
} else {
    echo '<script>alert("No data received");</script>';
    echo '<script>window.location.href="../templates/index.php";</script>';
}


?>
