<?php
require_once('../database/db.php');

if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    // Search query for matching products
    $query = $db->prepare("SELECT * FROM products WHERE product_name LIKE :searchQuery OR category LIKE :searchQuery ORDER BY product_id DESC");
    $query->execute(['searchQuery' => '%' . $searchQuery . '%']);
    $products = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!$products) {
        echo "<p style='color: red;'>No products found.</p>";
    } else {
        foreach ($products as $product) {
            ?>
            <div class="prod-item">
                <p><img src="../asset/images/product/<?= $product['product_image'] ?>" alt=""></p>
                <div class="prod-details">
                    <h4><?= $product['name'] ?></h4>
                    <div class="price">
                        <p>Price:</p>
                        <span><?= $product['price'] ?> RWF</span>
                    </div>
                    <a href="productdetail.php?product_id=<?= $product['product_id'] ?>">Product detail</a>
                    <a href="productdetail.php?product_id=<?= $product['product_id'] ?>"><i class="bi bi-bag-check"></i></a>
                </div>
            </div>
            <?php
        }
    }
}
?>
