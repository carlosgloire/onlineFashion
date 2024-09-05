<?php
    session_start();
    require_once('../../controllers/functions.php');
    require_once('../../database/db.php');
    notAdmin();
    logout_admin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>

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
    <link href="https://fonts.googleapis.com/css2?family=Kulim+Park:ital,wght@0,200;0,300;0,400;0,600;0,700&family=Raleway:ital,wght@0,100..900;1,100..900&family=Sulphur+Point:wght@300;400;700&display=swap" rel="stylesheet">

</head>

<body>

    <section class="admin-section">
        <div class="first-bloc">
            <nav>
                <a href="admindashboard.php">
                    <i class="bi bi-clipboard-pulse"></i>
                    <span>Dashboard</span>
                </a>
                <a class="activ" href="#">
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
                    <span>Payment history</span>
                </a>
                <form action="" method="post">
                    <button name="logout" class="logout-admin">
                        <i class="bi bi-power"></i> <span>Log out</span>
                    </button>
                </form>
            </nav>
        </div>

        <div class="all-prod-admin">
            <div class="menu-dash">
                <i class="bi bi-list-nested hamburger"></i>
            </div>
            <div class="overlay-dash"></div>
            <i class="bi bi-x-lg exit-dash"></i>
            <div class="">
                <div class="display-folder">
                    <form action="" method="GET" style="width: 80%;">
                        <input class="search" id="search" name="search" type="search" placeholder="Search..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    </form>
                    <a class="add-product" href="addproduct.php">Add a product</a>
                </div>
                <div id="product-container" class="all-product admin-prod">
                    
                <?php
                    $searchQuery = '';
                    $sql = 'SELECT * FROM products WHERE 1=1'; // Basic query
                    $params = [];

                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $searchQuery = htmlspecialchars($_GET['search']);

                        // Check if the search query is numeric to search by price, otherwise search by name
                        if (is_numeric($searchQuery)) {
                            $sql .= ' AND price = :search'; // Add price condition
                            $params[':search'] = $searchQuery;
                        } else {
                            $sql .= ' AND name LIKE :search'; // Add name condition
                            $params[':search'] = '%' . $searchQuery . '%'; // For partial matches
                        }
                    }

                    $query = $db->prepare($sql);

                    // Bind parameters only if they exist
                    foreach ($params as $key => $value) {
                        $query->bindValue($key, $value);
                    }

                    $query->execute();
                    $products = $query->fetchAll();

                    if (!$products) {
                        ?><div style="color:red"><?='No products found'?></div><?php
                    } else {
                        foreach ($products as $product) {
                            ?>
                            <div class="prod-item">
                                <p><img src="../product_images/<?=$product['product_image']?>" alt=""></p>
                                <div class="prod-details">
                                    <h4><?=$product['name']?></h4>
                                    <div class="price">
                                        <p>Price:</p>
                                        <span><?=$product['price']?> RWF</span>
                                    </div>
                                    <i style="color: #a64242" class="bi bi-trash3 delete" data-product-id="<?= $product['product_id'] ?>"></i>
                                    <a class="edit-prod" href="edit_product.php?product_id=<?=$product['product_id']?>"><i class="bi bi-pencil-square"></i></a>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>


                </div>
            </div>
    </section>

    <div class="popup hidden-popup" >
        <div class="popup-container">
            <h3>Dear Admin,</h3>
            <p>Are you sure you want to delete  this item <br>from your system?</p>
            <div style="margin-top: 20px; justify-content:space-between;display:flex" class="popup-btn">
                <button style="cursor:pointer;" class="cancel-popup icons-link">Cancel</button>
                <button style="cursor:pointer;" class="delete-popup icons-link">Delete</button>
            </div>
        </div>
    </div>

    <script src="../../asset/javascript/delete_product_popup.js"></script>
    <script src="../../asset/javascript/admin.js"></script>
</body>
</html>
