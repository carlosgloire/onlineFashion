<?php
    session_start();
    require_once('../../controllers/send-news-letter.php');
    require_once('../../controllers/functions.php');
    notAdmin();
    logout_admin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter</title>

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
                <a class="activ" href="newsletter.php">
                    <i class="bi bi-card-text"></i>
                    <span>Newsletter</span>
                </a>
                <a href="adminorders.php">
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
        <section class="login-section">
            <div class="newss">
                <div class="menu-dash">
                    <i class="bi bi-list-nested hamburger"></i>
                </div>
                <div class="overlay-dash"></div>
                <i class="bi bi-x-lg exit-dash"></i>

                <div class="login-form">
                    <h3>Newsletter</h3>
                    <form action="" method="post">
                        <div class="inputs">
                            <i class="bi bi-chat-dots"></i>
                            <input name="subject" type="text" placeholder="Message title">
                        </div>
                        <textarea name="message" style="border-radius: 5px;" name="" id="" placeholder="Write the message..."></textarea>
                        <div class="input-submit">
                            <input type="submit" name="send" value="Send the message">
                        </div>
                        <p style="color:red;font-size:13px;text-align:center"><?=$error?></p>
                        <p style="color:green;font-size:13px;text-align:center"><?=$success?></p>
                    </form>
                </div>
        </section>
    </section>

    <script src="../asset/javascript/admin.js"></script>
</body>

</html>