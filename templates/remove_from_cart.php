<?php
session_start();

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Find and remove the product from the cart
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['product_id'] == $product_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }

    // Re-index the array to avoid issues with numeric keys
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

header('Location: cart.php');
exit();
?>
