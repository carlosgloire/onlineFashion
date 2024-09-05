<?php
    session_start();
    require_once('../../controllers/functions.php');
    require_once('../../database/db.php');
    notAdmin();
    logout_admin();

    // Fetch the total number of users
    $totalUsersQuery = $db->prepare('SELECT COUNT(user_id) AS total_users FROM users');
    $totalUsersQuery->execute();
    $totalUsersResult = $totalUsersQuery->fetch(PDO::FETCH_ASSOC);
    $totalUsers = $totalUsersResult['total_users'];
    // Fetch the total number of products
    $totalproductQuery = $db->prepare('SELECT COUNT(product_id) AS total_products FROM products');
    $totalproductQuery->execute();
    $totalproductResult = $totalproductQuery->fetch(PDO::FETCH_ASSOC);
    $totalproducts = $totalproductResult['total_products'];

    // Fetch the total number of men's products
    $totalproductQuery = $db->prepare("SELECT COUNT(product_id) AS men FROM products WHERE category='Men'");
    $totalproductQuery->execute();
    $totalproductResult = $totalproductQuery->fetch(PDO::FETCH_ASSOC);
    $totalproducts_men = $totalproductResult['men'];
    // Fetch the total number of wenmen's products
    $totalproductQuery = $db->prepare("SELECT COUNT(product_id) AS wemen FROM products WHERE category='Wemen'");
    $totalproductQuery->execute();
    $totalproductResult = $totalproductQuery->fetch(PDO::FETCH_ASSOC);
    $totalproducts_wemen = $totalproductResult['wemen'];
    // Fetch the total number of orders
    $totalOrdersQuery = $db->prepare('SELECT COUNT(order_id) AS total_orders FROM orders');
    $totalOrdersQuery->execute();
    $totalOrdersResult = $totalOrdersQuery->fetch(PDO::FETCH_ASSOC);
    $totalOrders = $totalOrdersResult['total_orders'];

    // Fetch the total number of payment
    $totalPaymentQuery = $db->prepare('SELECT COUNT(payment_id) AS total_payment FROM payment');
    $totalPaymentQuery->execute();
    $totalPaymentResult = $totalPaymentQuery->fetch(PDO::FETCH_ASSOC);
    $totalpayments = $totalPaymentResult['total_payment'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>

    <!--css-->
    <link rel="stylesheet" href="../../asset/css/style.css">
    <link rel="stylesheet" href="../../asset/css/product.css">
    <link rel="stylesheet" href="../../asset/css/admin.css">
    <link rel="shortcut icon" href="asset/images/logo.png">

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
                <a class="activ" href="#">
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
                <a href="adminorders.php">
                    <i class="bi bi-border-style"></i>
                    <span>Orders</span>
                </a>
                <a href="payment_history.php">
                    <i class="bi bi-wallet2"></i>
                    <span>Payment</span>
                </a>
                <form action="" method="post">
                    <button name="logout" class="logout-admin">
                        <i class="bi bi-power"></i> <span>Log out</span>
                    </button>
                </form>
            </nav>
        </div>
        <div class="second-bloc">
            <div class="menu-dash">
                <i class="bi bi-list-nested hamburger"></i>
            </div>
            <div class="overlay-dash"></div>
            <i class="bi bi-x-lg exit-dash"></i>
            <div class="all-items">
                <div class="bloc-content">
                    <div>
                        <i class="bi bi-people"></i>
                        <p>Users</p>
                        <span><?=!empty($totalUsers)?$totalUsers:0?></span>
                    </div>
                    <div>
                        <i class="bi bi-bookmark-star"></i>
                        <p>Categories</p>
                        <span>2</span>
                    </div>
                    <div>
                        <i class="bi bi-people"></i>
                        <p>Products</p>
                        <span><?=!empty($totalproducts)?$totalproducts:0?></span>
                    </div>
                    <div>
                        <i class="bi bi-border"></i>
                        <p>Men's prod</p>
                        <span><?=!empty($totalproducts_men)?$totalproducts_men:0?></span>
                    </div>
                    <div>
                        <i class="bi bi-people"></i>
                        <p>Wemen's prod</p>
                        <span><?=!empty($totalproducts_wemen)?$totalproducts_wemen:0?></span>
                    </div>
                    <div>
                        <i class="bi bi-bookmark-star"></i>
                        <p>Orders</p>
                        <span><?=!empty($totalOrders)?$totalOrders:0?></span>
                    </div>
                    <div>
                        <i class="bi bi-bookmark-star"></i>
                        <p>Payment</p>
                        <span><?=!empty($totalpayments)?$totalpayments:0?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="../asset/javascript/admin.js"></script>
</body>

</html>