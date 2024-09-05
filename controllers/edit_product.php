<?php
$error = null;
$success = null;
require_once('../../database/db.php'); 

$name = $brand = $size = $color = $price = $description = $photo = $product_type = $product_category = '';

// Fetch shoe details if product_id is provided
if (isset($_GET['product_id']) && !empty($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $query = $db->prepare('SELECT * FROM products WHERE product_id = ?');
    $query->execute([$product_id]);
    $product = $query->fetch();
    if ($product) {
        $name = $product['name'];
        $size = $product['size'];
        $price = $product['price'];
        $description = $product['description'];
        $photo = $product['product_image'];
        $stock = $product['stock'];
        $product_category = $product['category'];
    } else {
        echo '<script>alert("Shoe ID not found.");</script>';
        echo '<script>window.location.href="index.php";</script>';
        exit; // Stop further execution if shoe ID is not found
    }
} else {
    echo '<script>alert("No shoe ID provided.");</script>';
    echo '<script>window.location.href="index.php";</script>';
    exit; // Stop further execution if shoe ID is not provided
}

// Process form submission
if (isset($_POST['edit'])) {
    $product_name = htmlspecialchars($_POST['name']);
    $product_size = htmlspecialchars($_POST['size']);
    $product_price = htmlspecialchars($_POST['price']);
    $product_stock = htmlspecialchars($_POST['stock']);
    $product_description = htmlspecialchars($_POST['description']);
    $new_shoe_category = htmlspecialchars($_POST['category']);
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "../../templates/product_images/" . $filename;
    $allowed_formats = array('jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG');

    // Validation and error checking
    if ($_FILES["uploadfile"]["size"] > 5000000) {
        $error = "Your photo should not exceed 5MB";
    } else {
        // Check if the new shoe name already exists in the database and is not the same as the current one
        $existing_shoe_query = $db->prepare("SELECT * FROM products WHERE name = :name AND product_id != :product_id");
        $existing_shoe_query->execute(array('name' => $product_name, 'product_id' => $product_id));
        $existing_shoe = $existing_shoe_query->fetch(PDO::FETCH_ASSOC);

        if ($existing_shoe) {
            $error = "The shoe <strong>" .$product_name. "</strong> you are trying to add already exists";
        } else {
            // Use the previous photo if no new photo is uploaded
            if (empty($filename)) {
                $filename = $photo;
            } else {
                // Move uploaded file to destination
                if (!move_uploaded_file($tempname, $folder)) {
                    $error = "Error uploading file";
                }
            }

            

            // Use the previous category if no new category is selected
            if ($new_shoe_category == 'category') {
                $new_shoe_category = $product_category;
            }

            // Update shoe details in the database
            $update_query = $db->prepare('UPDATE products SET name=?,  price=?,stock=?, description=?,  category=?, product_image=?, size=? WHERE product_id=?');
            $update_result = $update_query->execute([$product_name,  $product_price,$product_stock, $product_description,  $new_shoe_category, $filename, $product_size, $product_id]);

            if ($update_result) {
                echo "<script>alert('Shoe details updated successfully');</script>";
                echo '<script>window.location.href="../admin/adminproduct.php";</script>';
                exit;
                $success = "Shoe details updated successfully";
            } else {
                echo "<script>alert('Failed to update shoe details');</script>";
                echo '<script>window.location.href="../admin/shoes.php";</script>';
                exit;
            }
        }
    }
}
?>
