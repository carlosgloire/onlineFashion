<?php
session_start();
require_once('../controllers/functions.php');
require_once('../database/db.php');
logout();
notconnected();

$user_id = $_SESSION['user_id'];

$sql = "
SELECT 
    p.payment_date, 
    SUM(oiu.quantity) AS products_purchased, 
    p.payment_method, 
    p.amount, 
    p.status 
FROM 
    payment p 
JOIN 
    order_user ou ON p.order_id = ou.order_id 
JOIN 
    order_item_user oiu ON ou.order_id = oiu.order_id 
WHERE 
    ou.user_id = :user_id
GROUP BY 
    p.payment_date, 
    p.payment_method, 
    p.amount, 
    p.status
ORDER BY
    p.payment_date DESC     
";

$stmt = $db->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment history</title>

    <!--css-->
    <link rel="stylesheet" href="../asset/css/style.css">
    <link rel="stylesheet" href="../asset/css/product.css">
    <link rel="stylesheet" href="../asset/css/admin.css">

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

    <!-- Home page -->
    <section class="product-cover">
        <div class="padding">
            <h2>Payment</h2>
            <p>Lorem ipsum dolor sit amet.</p>
        </div>

        <div class="logout">
            <button>
                <i class="bi bi-power"></i>
                <span>Log out</span>
            </button>
        </div>

        <div class="waves">
            <svg width="100%" height="50px" viewBox="0 0 1920 130" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
                        <path d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,757 L1017.15166,757 L0,757 L0,439.134243 Z" id="Path"></path>
                    </g>
                </g>
            </svg>
        </div>
    </section>

    <section class="payment padding">
        <div class="title">
            <h2>Payment history</h2>
        </div>
        <div class="pay">
        <?php
            if(!$results){
                echo"<p style='text-align:center'>No payments already done !!</p>";
            }else{
                foreach($results as $result){
                    ?>
                        <div class="pay-container">
                            <div>
                                <h4>Date</h4>
                                <p><?=$result['payment_date']?></p>
                            </div>
                            <div>
                                <h4>Product purchased</h4>
                                <p><?=$result['products_purchased']?></p>
                            </div>
                            <div>
                                <h4>Payment method</h4>
                                <p><?=$result['payment_method']?></p>
                            </div>
                            <div>
                                <h4>Amount</h4>
                                <p><?=$result['amount']?></p>
                            </div>
                            <div class="stat">
                                <h4>Status</h4>
                                <p><i class="bi bi-check2-all"></i> Completed</p>
                            </div>
                        </div>
                    <?php
                }
            }
        ?>
                
        </div>

    </section>

</body>

</html>