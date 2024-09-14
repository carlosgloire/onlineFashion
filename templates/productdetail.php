<?php
    session_start();
    require_once('../database/db.php');
    if(isset($_GET['product_id']) && !empty($_GET['product_id'])){
        $product_id = $_GET['product_id'];
        $stmt = $db->prepare('SELECT * FROM products WHERE product_id = ?');
        $stmt->execute([$product_id]);
        $product_detail =$stmt->fetch(PDO::FETCH_ASSOC);
        $sizes = explode(',', $product_detail['size']);
        if(! $product_detail){
            echo "<script>alert('No product found');</script>";
            echo '<script>window.location.href="../templates/";</script>';
            exit;
        }
    }else{
        echo "<script>alert('No product found');</script>";
        echo '<script>window.location.href="../templates/";</script>';
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product details</title>

    <!--css-->
    <link rel="stylesheet" href="../asset/css/style.css">
    <link rel="stylesheet" href="../asset/css/product.css">

    <!--Icons-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.0/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />

    <!--Font family -->
    <link href="https://fonts.googleapis.com/css2?family=Kulim+Park:ital,wght@0,200;0,300;0,400;0,600;0,700;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kulim+Park:ital,wght@0,200;0,300;0,400;0,600;0,700;1,200;1,300;1,400;1,600;1,700&family=Raleway:ital,wght@0,100..900;1,100..900&family=Sulphur+Point:wght@300;400;700&display=swap" rel="stylesheet">

</head>

<body>

    <section class="view-prod padding">
        <div class="product-details">
            <div>
                <p><img class="view-image" src="product_images/<?=$product_detail['product_image']?>" alt=""></p>
            </div>
            <div>
                <span><?=$product_detail['category']?></span>
                <h3><?=$product_detail['name']?></h3>
                <div style="display: flex;">Quantity in stock: <span><?=$product_detail['stock']?></span></div>
                <h4><?=$product_detail['price']?> RWF</h4>
                <p><?=$product_detail['description']?></p>
                <div class="cart">
                    <div class="custom-dropdown">
                        <button class="dropdown-btn" id="size-btn">Select size</button>
                        <div class="dropdown-content" id="size-dropdown">
                            <?php foreach($sizes as $s): ?>
                                <label><input type="checkbox" value="<?=$s?>"> <?=$s?></label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <form id="cart-form" action="../controllers/add_to_cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?=$product_id?>">
                        <input type="hidden" name="selected_sizes" id="selected-sizes-input">
                        <button style="cursor:pointer" onclick="return storeSelections()" class="add-cart" name="ajouter_panier">Add to cart</button>
                    </form>
                   
                </div>
            </div>
        </div>
    </section>

    <script src="../asset/javascript/app.js"></script>
    <script>
        let selectedSizes = [];
        let selectedColors = [];

        document.querySelectorAll('#size-dropdown input[type="checkbox"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    selectedSizes.push(this.value);
                } else {
                    selectedSizes = selectedSizes.filter(size => size !== this.value);
                }
                console.log('Selected sizes:', selectedSizes);
            });
        });


        function storeSelections() {
            if (selectedSizes.length === 0) {
                alert("Please select at least one size.");
                return false;
            }

            document.getElementById('selected-sizes-input').value = JSON.stringify(selectedSizes);
            return true;
        }
    </script>
    
</body>

</html>