<!DOCTYPE html>
<html lang="de">

<?php 
    $pagetitle = "Home";
    require "../parts/head.php";
    checkIfInitStartup();
    if (isset($_POST['admin_login'])) {
    
        $username = $_POST['user_username'];
        $password = $_POST['user_password'];
    
        //get user data and ensure they are valid
        if (!preg_match($usernameRegex, $username)) {
            array_push($errors, "Username input contains unapproved Characters!");
        }
    
        if (empty($username) || empty($password)){
            array_push($errors, "Both Username and Password fields are required!"); 
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
                array_push($errors, "Wrong Information! Please try again.");
            }
        }
    }
?>

<body>
    <?php require "../parts/nav.php"; ?>
    <h1>Admin Login</h1>
    <section>
        <?php include('../parts/errors.php'); ?>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="user_username"><b>Username</b> (a-z0-9A-Z.-_)</label>
            <input type="text" id="user_username" name="user_username" placeholder="Username der User" pattern="<?php echo substr($usernameRegex, 1, -1); ?>" required>
            
            <label for="user_password"><b>Password</b></label>
            <input type="password" id="user_password" name="user_password" placeholder="Password der User" required>

            <input type="submit" value='Speichern' name='admin_login'>
        </form>
    </section>
    
</body>
</html>