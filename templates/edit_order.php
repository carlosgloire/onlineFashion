<?php
session_start();
require_once('../controllers/functions.php');
require_once('../database/db.php');

notconnected();

if (!isset($_GET['order_item_id']) || empty($_GET['order_item_id'])) {
    echo '<script>alert("No order item ID provided.");</script>';
    echo '<script>window.location.href="userdashboard.php";</script>';
    exit;
}
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo '<script>alert("No order item ID provided.");</script>';
    echo '<script>window.location.href="userdashboard.php";</script>';
    exit;
}

$order_item_id = $_GET['order_item_id'];
$order_id = $_GET['order_id'];
// Fetch the order item details
$query = $db->prepare("SELECT oi.*, p.name AS product_name, p.product_image, p.price 
                       FROM order_item_user oi 
                       JOIN products p ON oi.product_id = p.product_id
                       WHERE oi.order_item_id = ?");
$query->execute([$order_item_id]);
$order_item = $query->fetch(PDO::FETCH_ASSOC);


if (!$order_item) {
    echo '<script>alert("Order item not found.");</script>';
    echo '<script>window.location.href="userdashboard.php";</script>';
    exit;
}

// Fetch all products for the dropdown
$products_query = $db->prepare("SELECT * FROM products");
$products_query->execute();
$products = $products_query->fetchAll(PDO::FETCH_ASSOC);

// Fetch available sizes and colors for the selected shoe
$product_id= $order_item['product_id'];
$sizes_query = $db->prepare("SELECT size FROM products WHERE product_id = ?");
$sizes_query->execute([$product_id]);
$sizes = $sizes_query->fetchAll(PDO::FETCH_ASSOC);



$available_sizes = implode(', ', array_column($sizes, 'size'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id= $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $sizes = isset($_POST['sizes']) ? $_POST['sizes'] : $order_item['size'];

    // Fetch the price of the selected shoe
    $price_query = $db->prepare("SELECT price FROM products WHERE product_id = ?");
    $price_query->execute([$product_id]);
    $price = $price_query->fetchColumn();

    // Calculate the total price
    $total_price = $price * $quantity;

    $update_query = $db->prepare("UPDATE order_item 
                                  SET product_id = ?, quantity = ?, size = ?,  total_price = ? 
                                  WHERE order_id = ?");
    $update_query->execute([$product_id, $quantity, $sizes,  $total_price, $order_id]);
    
    $update_query = $db->prepare("UPDATE order_item_user 
                                  SET product_id = ?, quantity = ?, size = ?, total_price = ? 
                                  WHERE order_item_id = ?");
    $update_query->execute([$product_id, $quantity, $sizes,  $total_price, $order_item_id]);
    // Fetch the current date value from the orders table
    $date_query = $db->prepare("SELECT order_date FROM orders WHERE order_id = ?");
    $date_query->execute([$order_id]);
    $current_date = $date_query->fetchColumn();

    // Calculate the total amount from order_item
    $total_query = $db->prepare("SELECT SUM(total_price) as total_amount FROM order_item WHERE order_id = ?");
    $total_query->execute([$order_id]);
    $total_amount = $total_query->fetchColumn();

    // Update the total_amount in the orders table and retain the current date
    $update_orders_query = $db->prepare("UPDATE orders SET total_amount = ?, order_date = ? WHERE order_id = ?");
    $update_orders_query->execute([$total_amount, $current_date, $order_id]);

    // Fetch the current date value from the order_user table
    $date_user_query = $db->prepare("SELECT order_date FROM order_user WHERE order_id = ?");
    $date_user_query->execute([$order_id]);
    $current_user_date = $date_user_query->fetchColumn();

    // Calculate the total amount from order_item_user
    $total_user_query = $db->prepare("SELECT SUM(total_price) as total_amount FROM order_item_user WHERE order_id = ?");
    $total_user_query->execute([$order_id]);
    $total_user_amount = $total_user_query->fetchColumn();

    // Update the total_amount in the order_user table and retain the current date
    $update_order_user_query = $db->prepare("UPDATE order_user SET total_amount = ?, order_date = ? WHERE order_id = ?");
    $update_order_user_query->execute([$total_user_amount, $current_user_date, $order_id]);



    echo '<script>alert("Order item updated successfully.");</script>';
    echo '<script>window.location.href="userdashboard.php";</script>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../asset/images/logo-court.jpg" type="image/x-icon">
    <title>Update order item</title>

    <!--css-->
    <link rel="stylesheet" href="../asset/css/style.css">
    <link rel="shortcut icon" href="../asset/images/logo.png">

    <!--Icons-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.0/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />

    <!-- J-query -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!--Font family -->
    <link href="https://fonts.googleapis.com/css2?family=Kulim+Park:ital,wght@0,200;0,300;0,400;0,600;0,700;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kulim+Park:ital,wght@0,200;0,300;0,400;0,600;0,700;1,200;1,300;1,400;1,600;1,700&family=Raleway:ital,wght@0,100..900;1,100..900&family=Sulphur+Point:wght@300;400;700&display=swap" rel="stylesheet">

</head>

<body>

    <section class="login-section">
    <div class="login-content">
        <div class="login-form">
            <h3>Update order item</h3>
            <form method="POST" action="">
                <label for="product_name">Product Name:</label>
                <div class="inputs">
                <select style="width:100%" name="product_id" id="product_id">
                    <option value="<?= $order_item['product_id'] ?>">
                        <?= htmlspecialchars($order_item['product_name']) ?>
                    </option>
                    <?php foreach ($products as $product): ?>
                        <?= $product['product_id'] != $order_item['product_id'] ? '<option value="'.$product['product_id'].'">'.$product['name'].'</option>' : '' ?>
                    <?php endforeach; ?>
                </select>

                </div>
                <label for="product_name">Quantity:</label>
                <div class="inputs">
                    <input style="width:100%" type="number" name="quantity" id="quantity" value="<?= htmlspecialchars($order_item['quantity']) ?>" required>
                </div>
                <label style="margin-left: 20px;">Available Sizes: <?= htmlspecialchars($available_sizes) ?></label>
                <div class="inputs">
                    <input style="width:100%" type="text" name="sizes" id="sizes" value="<?= htmlspecialchars($order_item['size']) ?>" placeholder="e.g. 38, 39, 40" required>
                </div>
                <div class="input-submit">
                    <input type="submit" name="edit" value="UPDATE">
                </div>
            </form>
        </div>
    </div>

    </section>

</body>

</html>