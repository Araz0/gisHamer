<!DOCTYPE html>
<html lang="de">

<?php 
    $pagetitle = "Create User | Gishamer";
    require "./parts/head.php";
    if (isset($_POST['create_user'])) {
        $user_username = $_POST['user_username'];
        $user_password = $_POST['user_password'];
        $sec_question = $_POST['sec_question'];
        $sec_answer = $_POST['sec_answer'];

        if (empty($errors)) {
            createtUser($user_username, $user_password, $sec_question, $sec_answer);
        }
        header('Location: /');
    }
    
?>

<body>
    <?php require "parts/nav.php"; ?>
    <h1>User erstellen</h1>
    <section>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="user_username"><b>Username</b> (a-z0-9A-Z.-_)</label>
            <input type="text" id="user_username" name="user_username" placeholder="Username der User" pattern="<?php echo substr($usernameRegex, 1, -1); ?>" required>
            
            <label for="user_password"><b>Password</b></label>
            <input type="password" id="user_password" name="user_password" placeholder="Password der User" required>
            
            <label for="sec_question"><b>Security question</b></label>
            <input type="text" id="sec_question" name="sec_question" placeholder="Sicherheitsfrage der User" required>

            <label for="sec_answer"><b>Security answer</b></label>
            <input type="text" id="sec_answer" name="sec_answer" placeholder="Sicherheitsfrage Antwort der User" required>
            

            <input type="submit" value='Speichern' name='create_user'>
        </form>
    </section>
</body>
</html>