<?php
    require_once('../controllers/signup.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../asset/images/logo-court.jpg" type="image/x-icon">
    <title>Sign up</title>

    <!--css-->
    <link rel="stylesheet" href="../asset/css/style.css">
    <link rel="shortcut icon" href="../asset/images/logo.png">

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
                <h3>Create an account</h3>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="inputs">
                        <i class="bi bi-person"></i>
                        <input  name="fname" type="text" placeholder="Enter first name" value="<?=isset($_POST['fname'])?$_POST['fname']:''?>">
                    </div>
                    <div class="inputs">
                        <i class="bi bi-person"></i>
                        <input  name="lname" type="text" placeholder="Enter second name" value="<?=isset($_POST['lname'])?$_POST['lname']:''?>">
                    </div>
                    <div class="inputs">
                        <i class="bi bi-envelope"></i>
                        <input type="text" name="email" placeholder="Enter email" value="<?=isset($_POST['email'])?$_POST['email']:''?>">
                    </div>
                    <div class="inputs">
                        <i class="bi bi-telephone-x"></i>
                        <input type="text" id="phone" name="phone" placeholder="Enter phone number" value="<?=isset($_POST['phone'])?$_POST['phone']:''?>">
                    </div>
                    <div class="inputs">
                        <i class="bi bi-bank"></i>
                        <input type="text" id="address" name="address" placeholder="Enter your address" value="<?=isset($_POST['address'])?$_POST['address']:''?>">
                    </div>
                    <p style="margin-left: 15px;">Profile photo</p>
                    <div class="inputs">
                        <i class="bi bi-file-earmark-image"></i>
                        <input type="file" id="uploadfile" name="uploadfile" accept=".jpg, .jpeg, .png" value="<?=isset($_POST['uploadfile'])?$_POST['uploadfile']:''?>" >
                    </div>
                    <div class="inputs">
                        <i class="bi bi-key"></i>
                        <input type="password" name="password" placeholder="Create a password">
                    </div>
                    <div class="input-submit">
                        <input type="submit" name='register' value="Sign up">
                    </div>
                    <div class="create-account">
                        <p>Already have an account?</p>
                        <a href="./login.php">Sign in</a>
                    </div>
                    <p style="color:red;font-size:13px;text-align:center"><?=$error?></p><p style="color: green;font-size:13px;text-align:center"><?=$success?></p>
                </form>
            </div>
        </div>
    </section>

</body>

</html>