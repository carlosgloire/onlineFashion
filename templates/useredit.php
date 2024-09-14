<?php

session_start();
require_once('../database/db.php');
require_once('../controllers/delete_account.php');
require_once('../controllers/functions.php');

logout();
if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $_SESSION['user_id'] = $user_id; // Ensure session user_id is set
} elseif (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    echo '<script>alert("No user ID provided.");</script>';
    echo '<script>window.location.href="templates/";</script>';
    exit;
}

$query = $db->prepare('SELECT * FROM users WHERE user_id = ?');
$query->execute([$user_id]);
$user = $query->fetch();

if ($user) {
    $photo = $user['profile'];
    $fname = $user['firstname'];
    $lname = $user['lastname'];
    $email = $user['email'];
    $phone = $user['phone_number'];
    $address_fetched = $user['address'];
} else {
    echo '<script>alert("User ID not found.");</script>';
    echo '<script>window.location.href="templates/";</script>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../asset/images/logo-court.jpg" type="image/x-icon">
    <title>Login</title>

    <!--css-->
    <link rel="stylesheet" href="../asset/css/style.css">

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

    <section class="login-section">
        <div class="login-content">
            <div class="login-form">
                <h3>Edit user profile</h3>
                <form action="../controllers/update_userprofile.php" method="POST" enctype="multipart/form-data">
                    <div class="inputs">
                        <i class="bi bi-person"></i>
                        <input name="fname" type="text" placeholder="Enter first name" value="<?=$fname?>">
                    </div>
                    <div class="inputs">
                        <i class="bi bi-person"></i>
                        <input name="lname" type="text" placeholder="Enter second name" value="<?=$lname?>">
                    </div>
                    <div class="inputs">
                        <i class="bi bi-envelope"></i>
                        <input type="text" name="email" placeholder="Enter email" value="<?=$email?>">
                    </div>
                    <div class="inputs">
                        <i class="bi bi-telephone-x"></i>
                        <input type="text" id="phone" name="phone" placeholder="Enter phone number" value="<?=$phone?>">
                    </div>
                    <div class="inputs">
                        <i class="bi bi-bank"></i>
                        <input type="text" id="address" name="address" placeholder="Enter your address" value="<?=$address_fetched?>">
                    </div>
                    <p style="margin-left: 15px;">Profile photo</p>
                    <div class="inputs">
                        <i class="bi bi-file-earmark-image"></i>
                        <input type="file" id="uploadfile" name="uploadfile" accept=".jpg, .jpeg, .png">
                    </div>
                    <div class="inputs">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="current_password" placeholder="Enter your current password" required>
                    </div>
                    <div class="input-submit">
                        <input type="submit" name='edit' value="Update">
                    </div>
                    <p style="color:red;font-size:13px;text-align:center"><?=$error?></p>
                </form>

            </div>
        </div>
    </section>

</body>

</html>