<?php
session_start();
require_once('../../controllers/functions.php');
require_once('../../database/db.php');
require_once('../../controllers/functions.php');
logout_admin();
notAdmin();

// Fetch all orders, order items, and user details from the database
$query = $db->prepare("
    SELECT 
        o.order_id,
        o.order_date,
        o.status as order_status,
        u.firstname,
        u.lastname,
        u.address,
        u.phone_number,
        p.product_image,
        p.price,
        oi.size,
        p.name,
        oi.order_item_id,  
        oi.quantity,  
        oi.total_price
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    JOIN order_item oi ON o.order_id = oi.order_id
    JOIN products p ON oi.product_id = p.product_id
    ORDER BY u.firstname, u.lastname, o.order_date DESC
");
$query->execute();
$orders = $query->fetchAll(PDO::FETCH_ASSOC);

// Group orders by firstname, lastname, and order date
$grouped_orders = [];

foreach ($orders as $order) {
    $firstname = $order['firstname'];
    $lastname = $order['lastname'];
    $address = $order['address'];
    $phone = $order['phone_number'];
    $order_id = $order['order_id'];
    $date = date('d/m/Y', strtotime($order['order_date']));
    
    if (!isset($grouped_orders[$firstname])) {
        $grouped_orders[$firstname] = [];
    }
    if (!isset($grouped_orders[$firstname][$lastname])) {
        $grouped_orders[$firstname][$lastname] = [
            'address' => $address,
            'phone_number' => $phone,
            'dates' => []
        ];
    }
    if (!isset($grouped_orders[$firstname][$lastname]['dates'][$date])) {
        $grouped_orders[$firstname][$lastname]['dates'][$date] = [];
    }
    if (!isset($grouped_orders[$firstname][$lastname]['dates'][$date][$order_id])) {
        $grouped_orders[$firstname][$lastname]['dates'][$date][$order_id] = [];
    }
    $grouped_orders[$firstname][$lastname]['dates'][$date][$order_id][] = $order;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <!-- CSS and Icons -->
    <link rel="stylesheet" href="../../asset/css/style.css">
    <link rel="stylesheet" href="../../asset/css/product.css">
    <link rel="stylesheet" href="../../asset/css/admin.css">
    <link rel="shortcut icon" href="../../asset/images/logo.png">
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
    <section class="admin-section">
        <div class="first-bloc">
            <nav>
                <a href="admindashboard.php">
                    <i class="bi bi-clipboard-pulse"></i>
                    <span>Dashboard</span>
                </a>
                <a href="adminproduct.php">
                    <i class="bi bi-tag"></i>
                    <span>Product</span>
                </a>
                <a href="newsletter.php">
                    <i class="bi bi-card-text"></i>
                    <span>Newsletter</span>
                </a>
                <a class="activ" href="#">
                    <i class="bi bi-border-style"></i>
                    <span>Orders</span>
                </a>
                <a href="payment_history.php">
                    <i class="bi bi-wallet2"></i>
                    <span>Payment history</span>
                </a>
                <form action="" method="post">
                    <button name="logout" class="logout-admin">
                        <i class="bi bi-power"></i> <span>Log out</span>
                    </button>
                </form>
            </nav>
        </div>
        <div style="margin-top: 30px; padding-left: 30px; padding-right: 20px;" class="user-prod">
            <?php foreach ($grouped_orders as $firstname => $orders_by_firstname): ?>
                <?php foreach ($orders_by_firstname as $lastname => $user_details): ?>
                    <div class="admin-orders">
                        <div style=" justify-content: space-between; align-items:center; margin-bottom: 10px; flex-wrap:wrap;">
                            <div >
                            <div>
                                <h4><?php echo htmlspecialchars($firstname . ' ' . $lastname); ?></h4>
                                <p><?php echo htmlspecialchars($user_details['address'] . ' - ' . $user_details['phone_number']); ?></p>
                            </div>
                            <?php foreach ($user_details['dates'] as $date => $orders_by_date): ?>
                                <div style="font-weight: bold; margin-top: 20px;">
                                    <h4 ><?=$date?></h4>
                                </div>
                            </div>
                           
                                <?php foreach ($orders_by_date as $order_id => $items): 
                                    $total_order_price = 0;
                                    $pending_order_found = false;
                                    foreach ($items as $item):
                                        $total_order_price += $item['total_price'];
                                        if ($item['order_status'] == 'pending') {
                                            $pending_order_found = true;
                                        }
                                    ?>
                                    <div style="margin-top:10px ;" class="user-prod-container">
                                        <div class="user-prod-img">
                                            <img src="../../templates//product_images/<?php echo htmlspecialchars($items[0]['product_image']); ?>" alt="">
                                            <div class="user-prod-details">
                                                <h4><?php echo htmlspecialchars($items[0]['name']); ?></h4>
                                                <span><?php echo htmlspecialchars($items[0]['price']); ?> RWF</span>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>Size</h4>
                                            <p><?php echo htmlspecialchars($items[0]['size']); ?></p>
                                        </div>
                                        <div>
                                            <h4>Quantity</h4>
                                            <p><?php echo htmlspecialchars($items[0]['quantity']); ?></p>
                                        </div>
                                        <div>
                                            <h4>Total price</h4>
                                            <p><?php echo htmlspecialchars($items[0]['total_price']); ?> RWF</p>
                                        </div>
                                       
                                    </div>
                                    <?php endforeach; ?>
                                    <p style="text-align: right;margin-right: 30px;margin-top:20px;font-weight:600">Total order price: <?= htmlspecialchars($total_order_price) ?> RWF</p>
                                    <p style="text-align: right;margin-right: 30px;">
                                        <?php 
                                            switch ($items[0]['order_status']) {
                                                case 'pending':
                                                    echo "Payment status: Pending </span>";
                                                    break;
                                                case 'completed':
                                                    echo "Payment status: Completed <span style='color:green'>✔</span>";
                                                    break;
                                                case 'cancelled':
                                                    echo "Payment status: Cancelled ";
                                                    break;
                                            }
                                        ?>
                                    </p>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <script src="../../asset/js/index.js"></script>
    <script src="../../asset/js/admin.js"></script>
</body>
</html>
