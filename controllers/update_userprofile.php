<?php
session_start();
require_once('../database/db.php');

if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
    $user_id = $_SESSION['userID'];
} else {
    echo '<script>alert("No user ID provided.");</script>';
    echo '<script>window.location.href="../templates/";</script>';
    exit;
}

$query = $db->prepare('SELECT * FROM users WHERE user_id = ?');
$query->execute([$user_id]);
$user = $query->fetch();
if (!$user) {
    echo '<script>alert("User ID not found.");</script>';
    echo '<script>window.location.href="../templates/";</script>';
    exit;
}
$photo = $user['profile'];

if (isset($_POST['edit'])) {
    $firstname = htmlspecialchars($_POST['fname']);
    $lastname = htmlspecialchars($_POST['lname']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $filename = $_FILES["uploadfile"]["name"];
    $filesize = $_FILES["uploadfile"]["size"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "../templates/profiles/" . $filename;
    $allowedExtensions = ['png', 'jpg', 'jpeg'];
    $pattern = '/\.(' . implode('|', $allowedExtensions) . ')$/i';

    // Verify current password
    $current_password = $_POST['current_password'];
    if (!password_verify($current_password, $user['password'])) {
        echo '<script>alert("Incorrect password. Please try again.");</script>';
        echo '<script>window.location.href="../templates/useredit.php";</script>';
        exit;
    }

    // Check for existing email
    $existing_user_query = $db->prepare("SELECT * FROM users WHERE email = :email AND user_id != :user_id");
    $existing_user_query->execute(array('email' => $email, 'user_id' => $_SESSION['userID']));
    $existing_user = $existing_user_query->fetch(PDO::FETCH_ASSOC);

    if (empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($address)) {
        echo '<script>alert("Please complete all fields.");</script>';
        echo '<script>window.location.href="../templates/useredit.phpprofil.php";</script>';
        exit;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Your email is incorrect.");</script>';
        echo '<script>window.location.href="../templates/profil.php";</script>';
        exit;
    } elseif (!preg_match($pattern, $_FILES['uploadfile']['name']) && !empty($_FILES['uploadfile']['name'])) {
        echo '<script>alert("Your file must be in \"jpg, jpeg or png\" format");</script>';
        echo '<script>window.location.href="../templates/profil.php";</script>';
        exit;
    } elseif ($filesize > 3000000) {
        echo '<script>alert("Your file must not exceed 3Mb");</script>';
        echo '<script>window.location.href="../templates/useredit.php";</script>';
        exit;
    } elseif (!empty($filename) && !move_uploaded_file($tempname, $folder)) {
        echo '<script>alert("Error while uploading");</script>';
        echo '<script>window.location.href="../templates/useredit.php";</script>';
        exit;
    } elseif ($existing_user) {
        echo '<script>alert("There is another account created with the email address you entered in this system. Please change the email or delete the account.");</script>';
        echo '<script>window.location.href="../templates/useredit.php";</script>';
        exit;
    } else {
        if (empty($filename)) {
            $filename = $photo;
        }

        $query = $db->prepare("UPDATE users SET firstname = ?, lastname = ?, email = ?, phone_number = ?, address = ?, profile = ? WHERE user_id = ?");
        $update = $query->execute(array($firstname, $lastname, $email, $phone, $address, $filename, $_SESSION['userID']));

        if ($update) {
            echo '<script>alert("Profile updated successfully.");</script>';
            echo '<script>window.location.href="../templates/";</script>';
            session_destroy();
            exit;
        } else {
            echo '<script>alert("Error updating profile.");</script>';
            echo '<script>window.location.href="../templates/useredit.php";</script>';
            exit;
        }
    }
}
?>
