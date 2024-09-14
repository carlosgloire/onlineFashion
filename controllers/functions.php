<?php
function notconnected(){
    if (! isset($_SESSION['user'])) {
        // Redirect to the login page if not logged in
        header("Location: ../templates/login.php");
        exit();
    }
}

function notAdmin(){
    
$db = new PDO("mysql:host=localhost;dbname=Online_fashion_store_management_system", "root", "",
 [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $query = $db->prepare('SELECT role FROM users WHERE role =?');
    $query->execute(array($_SESSION['role']));
     
    if(($_SESSION['role']) != 'admin'){
        header("Location: ../../templates/");
        exit();
    }
   
}
function logout(){
    if(isset($_POST['logout'])){
        session_destroy();
        header('location:../templates/');
        exit();
    }
}

function logout_admin(){
    if(isset($_POST['logout'])){
        session_destroy();
        header('location:../../templates/');
        exit();
    }
}
function popup_delete_count($error,$user) {
    ?>
        <div class="popup <?= isset($error) ? '' : 'hidden-popup' ?>">
            <div class="popup-container">
                <form action="" method="post">
                    <h3 style="margin-bottom: 10px;">Dear <?=$user['firstname']?> <?=$user['lastname']?>,</h3>
                    <p>To delete your account please enter your password</p>

                    <div class="inputs">
                        <i class="bi bi-key"></i>
                        <input  class="password" name="password2" type="password" placeholder="Enter password" value="<?=isset($password)?$password:""?>">
                    </div>
                    <div style="margin-top: 20px; justify-content:space-between;display:flex" class="popup-btn">
                        <button type="button" style="cursor:pointer;" class="cancel-popup icons-link" >Cancel</button>
                        <button name="delete" style="cursor:pointer;" class="delete-popup icons-link">Delete</button>
                    </div>
                    <?php
                    if (isset($error) && !empty($error)) {
                        ?><p style="color:red;text-align:center;margin-top:10px"><?=$error?></p><?php
                    }
                    ?>
                </form>
            </div>
        </div>
   
    <?php
}
