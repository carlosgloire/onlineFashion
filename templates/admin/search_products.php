

<?php
session_start();
require_once('../../database/db.php');
require_once('../../controllers/functions.php');
notAdmin();
$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = $db->prepare('SELECT * FROM products WHERE name LIKE :search');
$query->execute(['search' => '%' . $search . '%']);
$products = $query->fetchAll();

if (empty($products)) {
    echo '<div style="color:red">No products found</div>';
} else {
    foreach ($products as $product) {
        ?>
        <div class="prod-item">
            <a href="productsdetails.php?product_id=<?=$product['product_id']?>"><p><img src="../../templates/product_images/<?=$product['product_image']?>" alt="<?=$product['name']?>"></p></a>
            <div class="item">
                <div class="item-details">
                    <p><?=$product['name']?></p>
                    <span><?=$product['price']?> RWF</span>
                </div>
            </div>
            <div class="categorie-item" style="box-shadow:none">
                <div>
                    <a href="small_images.php?product_id=<?=$product['product_id']?>"><i class="bi bi-file-image"></i></a>
                    <a href="editshoe.php?product_id=<?=$product['product_id']?>"><i class="bi bi-pen"></i></a>
                    <button class="delete" gallery_id="<?= $product['product_id'] ?>"><i class="bi bi-trash3"></i></button>
                    </div>
            </div>
        </div>

       
        <script src="../asset/javascript/delete_popup.js"></script>
        <?php
    }
}
?>
