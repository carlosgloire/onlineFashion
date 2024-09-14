<?php
    session_start();
    require_once('../../controllers/edit_product.php');
    require_once('../../controllers/functions.php');
    logout_admin();
    notAdmin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?= $name?></title>

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
                <a class="activ" href="#">
                    <i class="bi bi-tag"></i>
                    <span>Product</span>
                </a>
                <a href="newsletter.php">
                    <i class="bi bi-card-text"></i>
                    <span>Newsletter</span>
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
                    <h3>Edit <?= $name?></h3>
                    <form action=""  method="post" enctype="multipart/form-data">
                        <div class="inputs">
                            <input type="text" name="name" placeholder="Product name" value="<?= isset($name)? $name:''?>">
                        </div>
                        <div>
                            <select  style="border: none; width: 100%" class="inputs" name="category" id="">
                                <option value="category"> Select product category</option>
                                <option value="Men">Men</option>
                                <option value="Wemen">Wemen</option>
                            </select>
                        </div>
                        <div class="inputs">
                            <input type="number" name="price" placeholder="Product price" value="<?= isset($price)? $price:''?>">
                        </div>
                        <div class="inputs">
                            <input type="number" name="stock" placeholder="Total in stock" value="<?= isset($stock)? $stock:''?>">
                        </div>
                        <div class="inputs">
                            <input type="text" id="size" name="size"  value="<?= isset($size)? $size:''?>">
                        </div>

                        <div class="">
                            <textarea name="description" id="" ><?= isset($description)? $description:''?></textarea>
                        </div>
                        <div class="inputs">
                            <input type="file" name="uploadfile" id="">
                        </div>
                        <div class="input-submit" style="margin-bottom: 15px;">
                            <input type="submit" name="edit" value="Update">
                        </div>
                        <p style="color:red;font-size:13px;text-align:center"><?=$error?></p>
                    </form>
                </div>
            </div>
        </section>

    </section>

    <script src="../../asset/javascript/admin.js"></script>
</body>

</html>