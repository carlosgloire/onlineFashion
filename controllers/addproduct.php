
<?php
$error = null;
$success = null;
require_once('../../database/db.php');

if(isset($_POST['add'])){
    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $description = htmlspecialchars($_POST['description']);
    $category = htmlspecialchars($_POST['category']);
    $stock =htmlspecialchars($_POST['stock']);
    $filename = $_FILES["uploadfile"]["name"];
    $filesize = $_FILES["uploadfile"]["size"];
    $filetype = $_FILES["uploadfile"]["type"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "../../templates/product_images/" . $filename;
    $allowed_formats = array('jpg','jpeg','png','JPG','JPEG','PNG');
    // Récupération des valeurs des cases à cocher
    $size = isset($_POST["size"]) ? $_POST["size"] : [];
    // Convertir les sizes en une seule chaîne de caractères
    $size_string = implode(', ', $size); // This is the correct way to convert the array to a string
    $existing_product = $db->prepare('SELECT * FROM products WHERE name = :name AND  category= :category  AND size = :size AND price = :price AND stock = :stock  AND description = :description AND product_image = :product_image');
    $existing_product->execute(array('name' => $name,  'category' => $category,  'size' => $size_string, 'price' => $price, 'description' => $description,'stock' => $stock, 'product_image' => $filename));
    $get_products = $existing_product->fetch();
    if(empty($name)  || empty($price)  || empty($description) || empty($filename) || empty($stock)){
        $error = "Please fill all fields !!";
    } elseif($filesize > 5000000){
        $error = "Your photo should not exceed 5MB";
    } elseif($category == 'category_type'){
        $error = "Please select the category";
    } elseif($get_products){
        $error = "The product <strong>" .$name. "</strong> you are trying to add already exists";
    } else {
        if(!move_uploaded_file($tempname, $folder)){
            $error = "ERROR!!";
        } else {
            $query = $db->prepare('INSERT INTO products (name, category,  size, price, stock,  description, product_image) VALUES(:name,:category, :size, :price,:stock,  :description, :product_image)');
            $query->bindParam(':name', $name);
            $query->bindParam(':category', $category);
            $query->bindParam(':price', $price);
            $query->bindParam(':stock', $stock);
            $query->bindParam(':description', $description);
            $query->bindParam(':product_image', $filename);
            $query->bindParam(':size', $size_string, PDO::PARAM_STR); // Bind the size_string here
          
            $query->execute();
            $success = "product added successfuly";
        }
    }
}
