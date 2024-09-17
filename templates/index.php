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
    if (isset($_SESSION['userID'])) {
        $query = $db->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $query->execute(['user_id' => $_SESSION['userID']]);
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
    

    <!--css-->
    <link rel="stylesheet" href="../asset/css/style.css">

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
    <title>Home</title>
</head>

<body>

    <!-- Preloader -->
    <div class="preloader">
        <div class="spinner">
            <i class='bx bx-loader'></i>
        </div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="logo">
            <a href="#"><img src="../asset/images/logo.png" alt=""></a>
        </div>
        <div class="header-list">
            <ul>
                <li><a class="acti" href="#">Home</a></li>
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
                if (isset($_SESSION['user_credentials']) && $_SESSION['user_credentials']){
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
    <section class="cover-page">
        <div class="padding">
            <h2>Lorem ipsum dolor sit amet.</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis repellat veniam explicabo voluptatem, recusandae necessitatibus aspernatur illum delectus officia accusantium dicta? Corrupti ducimus eos neque!</p>
            <a href="login.php">Get started</a>
        </div>

        <div class="wave">
            <svg width="100%" height="400px" viewBox="0 0 1920 180" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
                        <path d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,757 L1017.15166,757 L0,757 L0,439.134243 Z" id="Path"></path>
                    </g>
                </g>
            </svg>
        </div>
    </section>

    <!--About us -->
    <section id="about" class="about-us padding">
        <div class="title">
            <h2>About us</h2>
        </div>

        <div class="about-container">

            <div class="about-items">
                <div class="all-items">
                    <div class="item-box">
                        <i class="bi bi-graph-up-arrow"></i>
                        <h4>Creation</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab aspernatur aliquid quo laudantium nobis numquam.</p>
                    </div>

                    <div class="item-box">
                        <i class="bi bi-calendar-check"></i>
                        <h4>Mission</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab aspernatur aliquid quo laudantium nobis numquam.</p>
                    </div>

                    <div class="item-box">
                        <i class="bi bi-bar-chart"></i>
                        <h4>Value</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab aspernatur aliquid quo laudantium nobis numquam.</p>
                    </div>

                    <div class="item-box">
                        <i class="bi bi-star"></i>
                        <h4>Goal</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab aspernatur aliquid quo laudantium nobis numquam.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Wrapper -->
  
    <section class="wrapper">
        <div class="wrapper-container padding">
            <div class="counter">
                <span class="num" data-val="10">0</span>
                <p>Experience</p>
            </div>
            <div class="counter">
                <span class="num" data-val="  <?=$orders['orders']?>">0</span>
                <p>Commandes</p>
            </div>
            <div class="counter">
                <span class="num" data-val="25">0</span>
                <p>Workers</p>
            </div>
        </div>
    </section>

    <!-- Why choose us -->
    <section class="choose-us">
        <div class="title">
            <h2>Why to choose us</h2>
        </div>

        <div class="choose-us-details padding">
            <div class="choose-item">
                <div class="lines">
                    <h5></h5>
                    <h6></h6>
                </div>
                <div class="choose-textbox">
                    <div>
                        <i class="bi bi-boxes"></i>
                        <h4>Lorem, ipsum dolor.</h4>
                    </div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non aliquam veniam temporibus saepe eius tenetur.</p>
                </div>
            </div>
            <div class="choose-item">
                <div class="lines">
                    <h5></h5>
                    <h6></h6>
                </div>
                <div class="choose-textbox">
                    <div>
                        <i class="bi bi-chat-dots"></i>
                        <h4>Lorem, ipsum dolor.</h4>
                    </div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non aliquam veniam temporibus saepe eius tenetur.</p>
                </div>
            </div>
            <div class="choose-item">
                <div class="lines">
                    <h5></h5>
                    <h6></h6>
                </div>
                <div class="choose-textbox">
                    <div>
                        <i class="bi bi-flower1"></i>
                        <h4>Lorem, ipsum dolor.</h4>
                    </div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non aliquam veniam temporibus saepe eius tenetur.</p>
                </div>
            </div>
            <div class="choose-item">
                <div class="lines">
                    <h5></h5>
                    <h6></h6>
                </div>
                <div class="choose-textbox">
                    <div>
                        <i class="bi bi-clipboard-data"></i>
                        <h4>Lorem, ipsum dolor.</h4>
                    </div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non aliquam veniam temporibus saepe eius tenetur.</p>
                </div>
            </div>
            <div class="choose-item">
                <div class="lines">
                    <h5></h5>
                    <h6></h6>
                </div>
                <div class="choose-textbox">
                    <div>
                        <i class='bx bxl-redux'></i>
                        <h4>Lorem, ipsum dolor.</h4>
                    </div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non aliquam veniam temporibus saepe eius tenetur.</p>
                </div>
            </div>
            <div class="choose-item">
                <div class="lines">
                    <h5></h5>
                    <h6></h6>
                </div>
                <div class="choose-textbox">
                    <div>
                        <i class='bx bx-pie-chart-alt-2'></i>
                        <h4>Lorem, ipsum dolor.</h4>
                    </div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non aliquam veniam temporibus saepe eius tenetur.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Product -->
    <section id="product" class="product padding">
        <div class="title">
            <h2>Products</h2>
        </div>

        <div class="all-product">
            <?php
                $query = $db->prepare('SELECT * FROM products LIMIT 6');
                $query->execute();
                $products = $query->fetchAll();
                if(! $products){
                    ?><div>No products already added !!</div><?php
                }else{
                    foreach($products as $product){
                        ?>
                            <div class="prod-item">
                                <p><img src="product_images/<?=$product['product_image']?>" alt=""></p>
                                <div class="prod-details">
                                    <h4><?=$product['name']?></h4>
                                    <div class="price">
                                        <p>Price:</p>
                                        <span><?=$product['price']?> RWF</span>
                                    </div>
                                    <a href="productdetail.php?product_id=<?=$product['product_id']?>">Product detail</a>
                                    <a href="productdetail.php?product_id=<?=$product['product_id']?>" title="Add to cart"><i class="bi bi-bag-check"></i></a>
                                </div>
                            </div>
                        <?php
                    }
                }
            ?>
            
        </div>

        <div class="see-more">
            <a href="product.php">See more </a>
            <i class="bi bi-arrow-right-short"></i>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter padding">
        <h4>Lorem ipsum dolor sit amet.</h4>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt eligendi magni debitis, earum quo deleniti.</p>
        <form action="../controllers/news-letter.php" method="post">  
            <div>
                    <input type="email" name="email" placeholder="Enter your email">  
                    <button name="send">Subscribe</button>
            
            </div>
        </form>
    </section>

    <!-- Testimonials -->
    <section id="testimonial" class="testimonials padding">
        <div class="title">
            <h2>Testimonials</h2>
        </div>
        <?php
            $query = $db->prepare("SELECT * FROM testimonials");
            $query->execute();
            $testimonials = $query->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="testimonial">
            <button class="prev"><i class="bi bi-chevron-double-left"></i></button>
            <a class="add-testimonial" href="addtestimonial.php">Add testimonial</a>
            <div>
                <div class="testimonial-content">
                    <?php foreach ($testimonials as $testimonial): ?>
                        <div class="testimonial-item">
                            <p><img src="profiles/<?=$testimonial['profile']?>" alt=""></p>
                            <div>
                                <h5><?=$testimonial['names']?></h5>
                                <span><?=$testimonial['job_title']?></span>
                                <p><i class='bx bxs-quote-alt-left'></i><?=$testimonial['testimony']?> <i class='bx bxs-quote-alt-right'></i></p>
                            </div>
                        </div> 
                    <?php endforeach; ?>
                    
                </div>
                <div class="test-btn">
                    <?php for ($i = 0; $i < count($testimonials); $i++): ?>
                    <div class="circle <?= $i === 0 ? 'active' : ''; ?>"></div>
                    <?php endfor; ?>
                </div>
              
            </div>
            <button class="next"><i class="bi bi-chevron-double-right"></i></button>
        </div>

    </section>

    <!-- Contact us -->
    <section id="contact" class="contact-us padding">
        <div class="title">
            <h2>Contact us</h2>
        </div>

        <div class="contact-info">
            <div>
                <i class="bi bi-geo-alt"></i>
                <h4>Location</h4>
                <p>Kigali, Nyamirambo</p>
            </div>
            <div>
                <i class="bi bi-envelope"></i>
                <h4>Email</h4>
                <a href="#">anicet@gmail.com</a>
            </div>
            <div>
                <i class="bi bi-phone"></i>
                <h4>Phone</h4>
                <a href="#">+250 123 456 789</a>
            </div>
        </div>

        <div class="contact-input">
            <form action="../controllers/contact_us.php" method="post">
                <div>
                    <input type="text" name="noms" placeholder="Your name">
                    <input type="email" name="email" placeholder="Your email">
                </div>
                <input type="text" name="subject"  placeholder="Subject">
                <textarea  name="message" placeholder="Write your message..." name="" id="" rows="5"></textarea>
                <div>
                    <button name="send" type="submit">Send your message</button>
                </div>
            </form>    
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
    <script src="../asset/javascript/preload.js"></script>
    <script src="../asset/javascript/app.js"></script>

</body>

</html>