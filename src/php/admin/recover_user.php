<!DOCTYPE html>
<html lang="de">

<?php 
    $pagetitle = "Recover Password | Gishamer";
    require "../parts/head.php";
    
    if(userIsLoggedIn()){
        header("Location: /index.php");
    }

    if (isset($_POST['recover_user'])) {
        $user_username = $_POST['user_username'];
        $sec_question = $_POST['sec_question'];
        $sec_answer = $_POST['sec_answer'];

        $user = getUser($user_username);

        if ($user->sec_question != $sec_question || $user->sec_answer != $sec_answer) {
            array_push($errors, "Security Question or Answer is not correct!"); 
        }

        if (empty($errors)) {
            header('Location: /');
        }
        
    }
    
?>

<body>
    <?php require "../parts/nav.php"; ?>
    <h1>Password vergessen</h1>
    <section>
        <?php include('../parts/popups.php'); ?>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="user_username"><b>Username</b> (a-z0-9A-Z.-_)<br>
                <input type="text" id="user_username" name="user_username" placeholder="Username der User" pattern="<?php echo substr($usernameRegex, 1, -1); ?>" required>
            </label>
            
            <label for="sec_question"><b>Sicherheitsfrage wählen</b><br>
                <select id="sec_question" name="sec_question" required>
                    <option value="">Frage wählen...</option>
                    <?php foreach ($sec_questions as $i  => $question) : ?>
                        <option value="<?php echo $i; ?>"><?php echo $question; ?></option>
                    <?php endforeach ?>
                </select>
            </label>

            <label for="sec_answer"><b>Sicherheitsfrage Antwort</b><br>
                <input type="text" id="sec_answer" name="sec_answer" placeholder="Sicherheitsfrage Antwort" required>
            </label>
            
            <input type="submit" value='Reset' name='recover_user'>
        </form>
    </section>
</body>
</html>