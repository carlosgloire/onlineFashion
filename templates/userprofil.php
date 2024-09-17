<?php
    session_start();
    require_once('../database/db.php');
    require_once('../controllers/functions.php');
    require_once('../controllers/delete_account.php');
    logout();
   
        $query = $db->prepare('SELECT * FROM users WHERE user_id = ?');
        $query->execute(array($_SESSION['userID']));
        $user = $query->fetch(PDO::FETCH_ASSOC);
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>

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

    <section class="profile">
        <div class="profile-details">
            <div class="title">
                <h2>My profile</h2>
            </div>
            <form action="" method="post">
                <div class="logout">
                    <button name="logout">
                        <i class="bi bi-power"></i>
                        <span>Log out</span>
                    </button>
                </div>
            </form>
            <div class="user-profil">
                <div class="profil-img">
                    <p><img src="profiles/<?=$user['profile']?>" alt=""></p>
                    <div>
                        <h4><?=$user['firstname']?> <?=$user['lastname']?></h4>
                        <p><?=$user['address']?></p>
                    </div>
                </div>
                <div class="edit">
                    <a href="useredit.php"><i class="bi bi-pencil-square"></i> Edit</a>
                </div>
            </div>

            <div class="profil-info">
                <div class="info-box">
                    <div>
                        <h5>Personal information</h5>
                    </div>
                    <div class="edit">
                        <a href="useredit.php"><i class="bi bi-pencil-square"></i> Edit</a>
                    </div>
                </div>
                <div class="profile-item">
                    <div class="prof-item">
                        <div>
                            <span>First name</span>
                            <p><?=$user['firstname']?></p>
                        </div>
                        <div>
                            <span>Last name</span>
                            <p><?=$user['lastname']?></p>
                        </div>

                    </div>
                    <div class="prof-item">
                        <div>
                            <span>Phone</span>
                            <p><?=$user['phone_number']?></p>
                        </div>
                        <div>
                            <span>Email</span>
                            <p><?=$user['email']?></p>
                        </div>
                    </div>
                    <div class="prof-item">
                        <div>
                            <span>Country</span>
                            <p>Rwanda</p>
                        </div>
                        <div>
                            <span>Address</span>
                            <p><?=$user['address']?></p>
                        </div>
                    </div>
                   
                        <p style="color: red;cursor:pointer;text-align:center" class="delete" userID="<?=$_SESSION['userID'] ?>" title="Delete Account "><i  class="bi bi-trash3" ></i></p>
                        <?=popup_delete_count($error,$user)?>
                        <script src="../asset/javascript/popup_ddelete_account.js"></script>
                </div>
            </div>
        </div>
    </section>

</body>

</html>