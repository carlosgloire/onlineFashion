<?php
session_start();
require_once('../controllers/functions.php');
require_once('../database/db.php');

notconnected();

if (!isset($_GET['order_item_id']) || empty($_GET['order_item_id'])) {
    echo '<script>alert("No order item ID provided.");</script>';
    echo '<script>window.location.href="../templates/userdashboard.php";</script>';    exit;
}

$order_item_id = $_GET['order_item_id'];

$delete_query = $db->prepare("DELETE FROM order_item_user WHERE order_item_id = ?");
$delete_query->execute([$order_item_id]);

echo '<script>alert("Order item deleted successfully.");</script>';
echo '<script>window.location.href="../templates/userdashboard.php";</script>';
exit;
?>
