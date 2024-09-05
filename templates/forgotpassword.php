<?php
    require_once('../controllers/send-password-reset.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../asset/images/logo-court.jpg" type="image/x-icon">
    <title>Forgot password</title>

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
                <h3>Forgot password</h3>
                <form action="" method="post">
                    <div class="inputs">
                        <i class="bi bi-envelope"></i>
                        <input type="email" name="email" placeholder="Enter your email">
                    </div>
                    <div class="input-submit">
                        <input type="submit" name="send" value="Change password">
                    </div>
                    <p style="color:red;font-size:13px;text-align:center"><?=$error?></p>
                    <p style="color:green;font-size:13px;text-align:center"><?=$success?></p>
                </form>
            </div>
        </div>
    </section>

</body>

</html>