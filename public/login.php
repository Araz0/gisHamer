<!DOCTYPE html>
<html lang="de">

<?php 
    $pagetitle = "Login | Gishamer";
    require "parts/head.php";

    if(userIsLoggedIn()){
        header("Location: /index.php");
    }

    if (isset($_POST['admin_login'])) {
    
        $username = $_POST['user_username'];
        $password = $_POST['user_password'];
    
        //get user data and ensure they are valid
        if (!preg_match($usernameRegex, $username)) {
            array_push($errors, "Username enthält unerlaubte Zeichen!");
        }
    
        if (empty($username) || empty($password)){
            array_push($errors, "Username und Passwort muss ausgefüllt sein!"); 
        }elseif (count($errors) == 0){
            //get user info
            $userObj = getUser($username);
            //verify user credentials
            if ($userObj != null && password_verify($password, $userObj->password)) {
                $_SESSION["USER"] = $userObj->username;
                // HTTPonly
                setcookie("USER", $userObj->username, time()+2*24*60*60, NULL, NULL, NULL, TRUE);
                header("Location: index.php");
                exit;
            }else{
                array_push($errors, "Username oder Passwort inkorrekt!");
            }
        }
    }
?>

<body>
    <?php require "parts/nav.php"; ?>
    <h1>Admin Login</h1>
    <section>
        <?php include('parts/popups.php'); ?>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="user_username"><b>Username</b> (a-z0-9A-Z.-_)<br>
                <input type="text" id="user_username" name="user_username" placeholder="Username" pattern="<?php echo substr($usernameRegex, 1, -1); ?>" required>
            </label>
            
            <label for="user_password"><b>Passwort</b><br>
                <input type="password" id="user_password" name="user_password" placeholder="Passwort" required>
            </label>

            <a href="/admin/recover_user.php">Passwort vergessen?</a>
            <input type="submit" value='Login' name='admin_login'>
        </form>
    </section>
</body>
</html>