<?php
    session_start();
    require_once('../database/db.php');
    require_once('../controllers/functions.php');
    logout();
    // Calculate the total quantity of all orders
    $total_quantity = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total_quantity += (isset($item['quantity']) ? $item['quantity'] : 0);
        }
    }
    $user = null;
    if (isset($_SESSION['user_id'])) {
        $query = $db->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $query->execute(['user_id' => $_SESSION['user_id']]);
        $user = $query->fetch();
    }

    $stmt = $db->prepare('SELECT COUNT(*) AS orders FROM orders ');
    $stmt->execute();
    $orders = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    <!--css-->
    <link rel="stylesheet" href="../asset/css/style.css">
    <link rel="stylesheet" href="../asset/css/product.css">

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


    <!-- Header -->
    <header class="header">
        <div class="logo">
            <a href="#"><img src="../asset/images/logo.png" alt=""></a>
        </div>
        <div class="header-list">
            <ul>
                <li><a class="acti" href="index.php">Home</a></li>
                <li><a href="#about">About us</a></li>
                <li><a href="#product">Products</a></li>
                <li><a href="#testimonial">Testimonials</a></li>
                <li><a href="#contact">Contacts</a></li>
            </ul>
            <div class="menu">
                <i class="bi bi-list-nested menu-icon"></i>
            </div>
            <div class="overlay"></div>
            <i class="bi bi-x-lg exit"></i>
            <?php
                if (isset($_SESSION['user']) && $_SESSION['user']){
                    ?>
                        <div class="online">
                            <div class="online-img">
                                <p><img src="profiles/<?=$user['profile']?>" alt="profile photo"></p>
                                <i class="bi bi-arrow-down-short down-icon"></i>
                            </div>
                            <div class="options none">
                                <div>
                                    <?php
                                        $admin=$user['role'];
                                        if($admin=='admin'){
                                            ?>
                                                <a href="admin/admindashboard.php">Admnistration</a>

                                            <?php
                                        }
                                    ?>
                                    <a href="userdashboard.php">Dashboard</a>
                                    <a href="userprofil.php">Profile</a>
                                    <a href="cart.php">My cart</a>
                                    <a href="userhistorypayment_history.php">Payment</a>
                                    <form style="background-color: #f4f4f4;" action="" method="post">
                                        <button style="cursor: pointer;" name="logout">
                                            <i class="bi bi-box-arrow-right"></i> <span>Log out</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php
                }
            ?>
            <div class="mycart">
                <a href="cart.php"><i class="bi bi-bag-check"></i></a>
                <span><?= ($total_quantity > 0) ? str_pad($total_quantity, 2, '0', STR_PAD_LEFT) : '00' ?></span>
            </div>
        </div>
    </header>


    <!-- Home page -->
    <section class="product-cover">
        <div class="padding">
            <h2>Our products</h2>
            <p>Lorem ipsum dolor sit amet.</p>
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

  

    <section class="prod-page padding">
        <div class="all-pages">
            <input class="search" type="search" placeholder="Search...">

            <div class="categories-list">
                <ul>
                    <li class="active" data-filter="all-shirt">All</li>
                    <li data-filter="men-shirt">Men</li>
                    <li data-filter="wemen-shirt">Wemen</li>
                </ul>
            </div>
        </div>
        <div class="all-product">
            <div class="shirt-item all-shirt">
            <?php
                $query = $db->prepare("SELECT * FROM products  ORDER BY product_id DESC");
                $query->execute();
                $products = $query->fetchAll(PDO::FETCH_ASSOC);
                if(! $products){
                    ?><p style="color: red;"><?= "No shoes added in this category"?></p><?php
                }
                else{
                    foreach($products as $product){
                        ?>
                            <div class="prod-item shirt">
                                <p><img src="../asset/images/product/<?=$product['product_image']?>" alt=""></p>
                                <div class="prod-details">
                                    <h4>Shirt</h4>
                                    <div class="price">
                                        <p>Price:</p>
                                        <span><?=$product['price']?> RWF</span>
                                    </div>
                                    <a href="productdetail.php?product_id=<?=$product['product_id']?>">Product detail</a>
                                    <a href="productdetail.php?product_id=<?=$product['product_id']?>"> <i class="bi bi-bag-check"></i></a>
                                </div>
                            </div>
                        <?php
                    }
                   
                }
                ?>
            </div>

            <div class="shirt-item men-shirt">
                
            <?php
                $query = $db->prepare("SELECT * FROM products WHERE category='Men'  ORDER BY product_id DESC");
                $query->execute();
                $products = $query->fetchAll(PDO::FETCH_ASSOC);
                if(! $products){
                    ?><p style="color: red;"><?= "No shoes added in this category"?></p><?php
                }
                else{
                    foreach($products as $product){
                        ?>
                            <div class="prod-item shirt">
                                <p><img src="../asset/images/product/<?=$product['product_image']?>" alt=""></p>
                                <div class="prod-details">
                                    <h4>Shirt</h4>
                                    <div class="price">
                                        <p>Price:</p>
                                        <span><?=$product['price']?> RWF</span>
                                    </div>
                                    <a href="productdetail.php?product_id=<?=$product['product_id']?>">Product detail</a>
                                    <a href="productdetail.php?product_id=<?=$product['product_id']?>"> <i class="bi bi-bag-check"></i></a>

                                </div>
                            </div>
                        <?php
                    }
                   
                }
                ?>
            </div>

            <div class="shirt-item wemen-shirt">
                     
            <?php
                $query = $db->prepare("SELECT * FROM products WHERE category='Wemen'  ORDER BY product_id DESC");
                $query->execute();
                $products = $query->fetchAll(PDO::FETCH_ASSOC);
                if(! $products){
                    ?><p style="color: red;"><?= "No shoes added in this category"?></p><?php
                }
                else{
                    foreach($products as $product){
                        ?>
                            <div class="prod-item shirt">
                                <p><img src="../asset/images/product/<?=$product['product_image']?>" alt=""></p>
                                <div class="prod-details">
                                    <h4>Shirt</h4>
                                    <div class="price">
                                        <p>Price:</p>
                                        <span><?=$product['price']?> RWF</span>
                                    </div>
                                    <a href="productdetail.php?product_id=<?=$product['product_id']?>">Product detail</a>
                                    <a href="productdetail.php?product_id=<?=$product['product_id']?>"> <i class="bi bi-bag-check"></i></a>

                                </div>
                            </div>
                        <?php
                    }
                   
                }
                ?>
            </div>

        </div>
    </section>


    <footer>
        <h3>Online fashion store management system</h3>
        <p>© 2024 Uzima Bora. All rights reserved. <br>Crafted with 🧠 and ✨ by <a href="https://github.com//AnicetChiza/">Anicet Chiza.</a></p>

        <div class="up scrollUp">
            <i class="bi bi-arrow-up-short"></i>
        </div>
    </footer>

    <!-- Javascript pages -->
    <script src="../asset/javascript/app.js"></script>
</body>

</html>