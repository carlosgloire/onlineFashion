<?php
$success = null;
$error = null;
require_once('../database/db.php');

if (isset($_POST['add'])) {
    $name = htmlspecialchars($_POST['name']);
    $role= htmlspecialchars($_POST['role']);
    $message = htmlspecialchars($_POST['message']);
    $filename = $_FILES["uploadfile"]["name"];
    $filesize = $_FILES["uploadfile"]["size"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./profiles/" . $filename;
    $allowedExtensions = ['png', 'jpg', 'jpeg'];
    $pattern = '/\.(' . implode('|', $allowedExtensions) . ')$/i';

    if (empty($name)   || empty($role) || empty($message)) {
        $error = "Please complete all the fields";
    } elseif (empty($filename)) {
        $error = "Select a profile photo for this testimonial"; 
    } elseif (!preg_match($pattern, $_FILES['uploadfile']['name']) && !empty($_FILES['uploadfile']['name'])) {
        $error = "Votre fichier doit être au format \"jpg, jpeg ou png\"";
    } elseif ($filesize > 5000000) {
        $error = "Your photo cannot exceed 5MB";
    }else {
        // Check if a product already exists
        $existing_testimonial_query = $db->prepare("SELECT * FROM testimonials WHERE names =:names ");
        $existing_testimonial_query->execute(array('names' => $name));
        $existing_testimonial = $existing_testimonial_query->fetch(PDO::FETCH_ASSOC);
        
        if ($existing_testimonial) {
            $error = "This testimonial already exist";
        } else {
            // Insert into collection table
            $query = $db->prepare('INSERT INTO testimonials (names, job_title ,testimony,profile) VALUES (:names, :job_title ,:testimony,:profile)');
            $query->bindParam(':names', $name);
            $query->bindParam(':job_title', $role);
            $query->bindParam(':testimony', $message);
            $query->bindParam(':profile', $filename);
            if ($query->execute()) {
                // Move the uploaded file to the target folder
                if (move_uploaded_file($tempname, $folder)) {
                    $success = "Testimonial added successfully";
                } else {
                    $error = "Error while donwnloading images";
                }
            } else {
                $error = "Error while adding testimony";
            }
        }
    }
}
?>