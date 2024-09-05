<?php
session_start();
require_once('../controllers/functions.php');
require_once('../database/db.php');
logout();
notconnected();

// Fetch orders, order items, and product details from the database
$user_id = $_SESSION['user_id'];
$query = $db->prepare("
    SELECT 
        o.order_id,
        o.order_date,
        o.status as order_status,
        o.total_amount,
        p.name,
        p.product_image,
        p.price,
        order_item_id,
        oi.size, 
        oi.quantity,  
        oi.total_price
    FROM order_user o
    JOIN order_item_user oi ON o.order_id = oi.order_id
    JOIN products p ON oi.product_id = p.product_id
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC
");
$query->execute([$user_id]);
$orders = $query->fetchAll(PDO::FETCH_ASSOC);

// Group orders by order_id and date
$grouped_orders = [];

foreach ($orders as $order) {
    $order_id = $order['order_id'];
    $date = date('d/m/Y', strtotime($order['order_date']));
    if (!isset($grouped_orders[$date])) {
        $grouped_orders[$date] = [];
    }
    if (!isset($grouped_orders[$date][$order_id])) {
        $grouped_orders[$date][$order_id] = [];
    }
    $grouped_orders[$date][$order_id][] = $order;
}
$pending_order_found = false; // Initialize the flag

// Iterate over all orders to check if there is any pending order
foreach ($orders as $order) {
    if ($order['order_status'] === 'pending') {
        $pending_order_found = true;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User dashboard</title>

    <!--css-->
    <link rel="stylesheet" href="../asset/css/style.css">
    <link rel="stylesheet" href="../asset/css/product.css">
    <link rel="shortcut icon" href="../asset/images/logo.png">

    <!--Icons-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.0/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <!-- J-query -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!--Font family -->
    <link href="https://fonts.googleapis.com/css2?family=Kulim+Park:wght@200;300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kulim+Park&family=Raleway:wght@100..900&family=Sulphur+Point:wght@300;400;700&display=swap" rel="stylesheet">

</head>
<style>
    .pay{
    color: #fff;
    font-weight: 700;
    padding: 10px 15px;
    border-radius: 20px;
    justify-content: center;
    background-color: #37517e;
    margin: auto;
    }
</style>
<body>

    <!-- Home page -->
    <section class="product-cover">
        <div class="padding">
            <h2>User dashboard</h2>
            <p>Welcome to your dashboard</p>
        </div>
        <form action="" method="post">
            <div class="logout">
                <button name="logout">
                    <i class="bi bi-power"></i>
                    <span>Log out</span>
                </button>
            </div>
        </form>
        

        <div class="waves">
            <svg width="100%" height="50px" viewBox="0 0 1920 130">
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Apple-TV" transform="translate(0, -402)" fill="#FFFFFF">
                        <path d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,757 L1017.15166,757 L0,757 L0,439.134243 Z"></path>
                    </g>
                </g>
            </svg>
        </div>
    </section>

    <section class="user-dashboard padding">
        <div class="user-items">
            <a href="userprofil.php">Profile</a>
            <a href="useredit.php">Edit profile</a>
            <a href="cart.php">Cart</a>
            <a href="userhistorypayment_history.php">Payment history</a>
        </div>
    </section>
    
    <section class="user-prod padding">
        <?php foreach ($grouped_orders as $date => $orders_by_date): ?>
            <div class="user-date"><?= $date ?></div>
            <?php foreach ($orders_by_date as $order_id => $order_items): ?>
                <?php foreach ($order_items as $order): ?>
                    <div class="user-prod-container">
                        <div class="user-prod-img">
                            <img src="../asset/images/product/<?= $order['product_image'] ?>" alt="<?= $order['name'] ?>">
                            <div class="user-prod-details">
                                <h4><?= $order['name'] ?></h4>
                                <span><?= $order['price'] ?> RWF</span>
                            </div>
                        </div>
                        <div>
                            <h4>Size</h4>
                            <p><?= $order['size'] ?></p>
                        </div>
                        <div>
                            <h4>Quantity</h4>
                            <p><?= $order['quantity'] ?></p>
                        </div>
                        <div>
                            <h4>Total price</h4>
                            <p><?= $order['total_price'] ?> RWF</p>
                        </div>
                        <div style="text-align: left;">
                            <div class="delete" data-order-item-id="<?= $order['order_item_id'] ?>">
                                <div><i class="bi bi-trash3"></i> Delete</div>
                            </div>
                            <div style="background-color:none;">
                                <a href="edit_order.php?order_item_id=<?= $order['order_item_id'] ?>&order_id=<?= $order_id ?>" style="color: black;"> 
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                            </div>
                        </div>
                        
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <p style="text-align: right;margin-right: 30px;margin-top:20px;font-weight:600">Total order price: <?= htmlspecialchars($order['total_amount']) ?> RWF</p>
        <div >

            <?php if ($pending_order_found): ?>
                <a href="payment_order.php?order_id=<?= $order_id ?>"   class="pay">Pay now</a>
            <?php else: ?>
                <p style="text-align: right;margin-right: 30px;">
                    <?php 
                        switch ($order['order_status']) {
                            case 'completed':
                                echo "Payment completed <span style='color:green'>✔</span>";
                                break;
                            case 'cancelled':
                                echo "Payment failed ❌";
                                break;
                        }
                    ?>
                </p>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </section>

    <div class="popup hidden-popup">
        <div class="popup-container">
            <h3>Dear Admin,</h3>
            <p>Are you sure you want to delete this item <br>from your system?</p>
            <div style="margin-top: 20px; justify-content:space-between;display:flex" class="popup-btn">
                <button style="cursor:pointer;" class="cancel-popup icons-link">Cancel</button>
                <button style="cursor:pointer;" class="delete-popup icons-link">Delete</button>
            </div>
        </div>
    </div>

    <script src="../asset/javascript/delete_order_popup.js"></script>
</body>

</html>
