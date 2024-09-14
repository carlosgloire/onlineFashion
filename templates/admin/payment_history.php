<?php
session_start();
require_once('../../controllers/functions.php');
require_once('../../database/db.php');
notAdmin();
logout_admin();

$sql = "
SELECT 
    u.firstname,
    u.lastname,
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
JOIN 
    users u ON ou.user_id = u.user_id
GROUP BY 
    u.firstname, 
    u.lastname, 
    p.payment_date, 
    p.payment_method, 
    p.amount, 
    p.status
ORDER BY
    p.payment_date DESC  
";

$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>

    <!--css-->
    <link rel="stylesheet" href="../../asset/css/style.css">
    <link rel="stylesheet" href="../../asset/css/product.css">
    <link rel="stylesheet" href="../../asset/css/admin.css">

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
                <a href="adminorders.php">
                    <i class="bi bi-border-style"></i>
                    <span>Orders</span>
                </a>
                <a class="activ" href="#">
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

        <section class="paym">
            <div class="title">
                <h2>Payment history</h2>
            </div>
            <div class="paye">
                <div class="menu-dash">
                    <i class="bi bi-list-nested hamburger"></i>
                </div>
                <div class="overlay-dash"></div>
                <i class="bi bi-x-lg exit-dash"></i>
                    <?php
                        if(!$results){
                            echo"<p style='text-align:center'>No payments already done !!</p>";
                        }else{
                            foreach($results as $result){
                                ?>
                                    <div class="pay-container">
                                        <div>
                                            <h4>Names</h4>
                                            <p><?=$result['firstname']?> <?=$result['lastname']?></p>
                                        </div>
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
    </section>

    <script src="../asset/javascript/admin.js"></script>
</body>

</html>