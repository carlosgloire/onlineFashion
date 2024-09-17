<?php
session_start();
require_once('../../controllers/functions.php');
require_once('../../database/db.php');
notAdmin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];

    // Update the 'delivered' column to 'Delivered' in both orders and order_user tables
    $query = $db->prepare("
        UPDATE orders SET delivered = 'Delivered' WHERE order_id = :order_id;
        UPDATE order_user SET delivered = 'Delivered' WHERE order_id = :order_id;
    ");
    $query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $query->execute();

    // Redirect back to the orders page
    header("Location: adminorders.php");
    exit();
}
