<?php
session_start();
require_once('../database/db.php');

if (isset($_GET['order_id']) && !empty($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $user_id = $_SESSION['userID'];
} else {
    echo '<script>alert("No order ID provided.");</script>';
    echo '<script>window.location.href="templates/";</script>';
    exit;
}

$order_query = $db->prepare('SELECT * FROM orders WHERE order_id = ?');
$order_query->execute([$order_id]);
$order = $order_query->fetch();

if (!$order) {
    header('Location: cart.php');
    exit();
}
//Select the price
$quantity_price = $db->prepare('SELECT SUM(total_price) AS total_amount FROM order_item_user WHERE order_id = ?');
$quantity_price->execute([$order_id]);
$totalorder = $quantity_price->fetchColumn();

$quantity_query = $db->prepare('SELECT SUM(quantity) AS total_quantity FROM order_item WHERE order_id = ?');
$quantity_query->execute([$order_id]);
$order_quantity = $quantity_query->fetchColumn();

// Fetch user details
$user_query = $db->prepare('SELECT email, phone_number, firstname, lastname FROM users WHERE user_id = ?');
$user_query->execute([$user_id]);
$user = $user_query->fetch();

if (!$user) {
    header('Location: cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../asset/images/logo-court.jpg" type="image/x-icon">
    <title>Payment</title>

    <!--css-->
    <link rel="stylesheet" href="../asset/css/style.css">

    <!--Icons-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.0/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <!-- J-query -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!--Font family -->
    <link href="https://fonts.googleapis.com/css2?family=Kulim+Park:ital,wght@0,200;0,300;0,400;0,600;0,700;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kulim+Park:ital,wght@0,200;0,300;0,400;0,600;0,700;1,200;1,300;1,400;1,600;1,700&family=Raleway:ital,wght@0,100..900;1,100..900&family=Sulphur+Point:wght@300;400;700&display=swap" rel="stylesheet">
    <script src="https://checkout.flutterwave.com/v3.js"></script>
</head>

<body>
    <style>
        button {
            width: 100%;
            color: #fff;
            font-weight: 700;
            padding: 10px 15px;
            border-radius: 20px;
            text-transform: uppercase;
            background-color: #37517e;
            border: none;
        }
    </style>
    <section class="login-section">
        <div class="login-content">
            <div class="login-form">
                <h3>Complete your payment</h3>
                <form action="" method="post">
                    <p style="margin-bottom: 10px; margin-top: 10px ;text-align:center">Order Total: <span style="color: #37517e;" id="order-total"><?= htmlspecialchars(number_format($totalorder, 2)) ?></span> RWF</p>
                    <div class="input-submit">
                        <button onclick="makePayment()" type="button">Pay now</button>
                    </div>
                </form>
            </div>
        </div>
        
        <script>
            const orderTotal = parseFloat(<?= json_encode($totalorder) ?>);
            const orderId = <?= json_encode($order_id) ?>;
            
            function makePayment() {
                console.log("makePayment function called"); // Debugging log
                const amount = orderTotal.toFixed(2); // Ensure amount is formatted correctly
                const redirectUrl = `confirmcheckout.php?order_id=${orderId}&amount=${amount}`;

                FlutterwaveCheckout({
                    public_key: "FLWPUBK_TEST-4045dbbe8d6ff97ac9b8dd12477461f8-X",
                    tx_ref: "RX1_" + Math.floor((Math.random() * 1000000000) + 1),
                    amount: parseFloat(amount),
                    currency: "RWF",
                    country: "RW",
                    payment_options: "mobilemoneyrwanda", // Set default or based on your needs
                    redirect_url: `http://localhost/onlineFashion/templates/${redirectUrl}`,
                    meta: {
                        consumer_id: 23,
                        consumer_mac: "92a3-912ba-1192a",
                    },
                    customer: {
                        email: "<?php echo htmlspecialchars($user['email']); ?>",
                        phone_number: "<?php echo htmlspecialchars($user['phone_number']); ?>",
                        name: "<?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?>",
                    },
                    callback: function (data) {
                        console.log("Payment data:", data);
                        window.location.href = `confirmcheckout.php?order_id=${orderId}&amount=${amount}`;
                    },
                    onclose: function() {
                        console.log("Payment modal closed.");
                    },
                    customizations: {
                        title: "Best Payment Gateway",
                        description: "Payment for your order",
                        logo: "img/favicon-32x32.png",
                    },
                });
            }
        </script>
    </section>
</body>

</html>
