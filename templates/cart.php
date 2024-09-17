<?php
session_start();
require_once('../database/db.php');
require_once('../controllers/functions.php');
logout();
// Handle form submission to update the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])){
    if (isset($_POST['products']) && !empty($_POST['products'])) {
        foreach ($_POST['products'] as $key => $product) {
            $product_id = $product['product_id'];
            $sizes = explode(',', str_replace(' ', '', $product['sizes']));
            $quantity = (int)$product['quantity'];

            // Update session data
            $_SESSION['cart'][$key]['product_id'] = $product_id;
            $_SESSION['cart'][$key]['sizes'] = $sizes;
            $_SESSION['cart'][$key]['quantity'] = $quantity;
        }
    }
}

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

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

    <!-- Home page -->
    <section class="product-cover">
        <div class="padding">
            <h2>Cart</h2>
            <p>Lorem ipsum dolor sit amet.</p>
        </div>

        <div class="logout">
            <form action="" method="post">
                <button name="logout">
                    <i class="bi bi-power"></i>
                    <span>Log out</span>
                </button>
            </form>
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
                <?php
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    $subtotal = 0;
                    ?>
                    <form method="POST" action="">
                        <?php
                        foreach ($_SESSION['cart'] as $key => $item) {
                            if (!isset($item['product_id'])) {
                                continue;
                            }
    
                            $product_id = $item['product_id'];
                            $query = $db->prepare('SELECT * FROM products WHERE product_id = ?');
                            $query->execute([$product_id]);
                            $produit = $query->fetch();
    
                            if ($produit) {
                                $quantity = isset($item['quantity']) ? $item['quantity'] : 0;
                                $total_price = $produit['price'] * $quantity;
                                $subtotal += $total_price;
                                ?>
                                 <section class="user-prod padding">
                                    <div class="user-prod-container">
                                        <div class="user-prod-img">
                                            <img src="product_images/<?=$produit['product_image']?>" alt="">
                                            <div class="user-prod-details">
                                                <h4><?=$produit['name']?></h4>
                                                <span><?=$produit['price']?> RWF</span>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>Size</h4>
                                            <input class="size" style="width:100%;color: #9a9a9a;font-family: 'Poppins', sans-serif;'" type="text" name="products[<?=$key?>][sizes]" value="<?=implode(', ', $item['sizes'])?>">
                                        </div>
                                        <div>
                                            <h4>Quantity</h4>
                                            <input type="hidden" name="products[<?=$key?>][product_id]" value="<?=$product_id?>">
                                            <input id="quantity-<?=$key?>" style="text-align:center; color: #9a9a9a;font-family: 'Poppins', sans-serif;" type="number" name="products[<?=$key?>][quantity]" value="<?=$quantity?>" min="1" data-stock="<?=$produit['stock']?>">
                                        </div>
                                        <div>
                                            <h4>Total price</h4>
                                            <p><?=$total_price?></p>
                                        </div>
                                        <div class="delete" class="remove" onclick="removeFromCart(<?=$product_id?>)" >
                                            <div><i class="bi bi-trash3"></i> Delete</div>
                                        </div>
                                    </div>
                                   
                                </section>
                               
                                <?php
                            }
                        }
                        ?>
                          <div class="order-cart">
                                <button name="update_cart">Update cart</button>
                                <button type="button"><a style="color:white" href="../controllers/process_order.php">Order now</a> </button>
                                <p>Total amout: <?=$subtotal?> RWF</p>
                            </div>
       
                    </form>
                    <?php
                } else {
                    ?>
                    <p style="text-align:center;color:#ff0000">No product added to cart, your cart is empty !!</p>
                    <?php
                }
                ?>
   


    <script src="../asset/javascript/popup.js"></script>
    <script>

    function removeFromCart(productId) {
        const form = document.createElement('form');
        form.method = 'post';
        form.action = 'remove_from_cart.php';
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'product_id';
        input.value = productId;
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }

    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('change', function() {
            const stock = parseInt(this.getAttribute('data-stock'));
            const value = parseInt(this.value);
            if (value > stock) {
                alert('The quantity entered is not available in stock.');
                this.value = stock;
            }
        });
    });

    </script>

</body>

</html>