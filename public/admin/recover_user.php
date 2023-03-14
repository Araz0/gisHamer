<!DOCTYPE html>
<html lang="de">

<?php 
    $pagetitle = "Password vergessen | Gishamer";
    require "../parts/head.php";
    
    if(userIsLoggedIn()){
        header("Location: /index.php");
    }
    
    $conformedToRecover = false;
    if (isset($_POST['recover_user'])) {
        $user_username = $_POST['user_username'];
        $sec_question = $_POST['sec_question'];
        $sec_answer = $_POST['sec_answer'];

        $user = getUser($user_username);
        $user_id = $user->id;
        if ($user->sec_question != $sec_question || $user->sec_answer != $sec_answer) {
            array_push($errors, "Die Antwort ist leider falsch!"); 
        }

        if (empty($errors)) {
            $conformedToRecover = true;
        }
    }

    if (isset($_POST['reset_user'])) {
        $user_id = $_POST['user_id'];
        $user_password_1 = $_POST['user_password_1'];
        $user_password_2 = $_POST['user_password_2'];

        $sec_question = $_POST['sec_question'];
        $sec_answer = $_POST['sec_answer'];

        if ($user_password_1 != $user_password_2) {
            array_push($errors, "Beide Passwörter müssen übereinstimmen!");
            $conformedToRecover = true;
        }
        
        if (empty($errors)) {
            updateUserSecurity($user_id, $user_password_1, $sec_question, $sec_answer);
            header('Location: /admin/login.php');
        }
    }
?>

<body>
    <?php require "../parts/nav.php"; ?>
    <h1>Password vergessen</h1>
    <section>
        <?php include('../parts/popups.php'); ?>
        <form action="" method="post" enctype="multipart/form-data">
            
            <?php if ($conformedToRecover) { ?>
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <label for="user_password_1"><b>Neues Passwort</b><br>
                    <input type="password" id="user_password_1" name="user_password_1" placeholder="Passwort" required>
                </label>

                <label for="user_password_2"><b>Passwort wiederholen</b><br>
                    <input type="password" id="user_password_2" name="user_password_2" placeholder="Passwort wiederholen" required>
                </label>
            <?php }else{ ?>
                <label for="user_username"><b>Username</b> (a-z0-9A-Z.-_)<br>
                    <input type="text" id="user_username" name="user_username" placeholder="Username" pattern="<?php echo substr($usernameRegex, 1, -1); ?>" required>
                </label>
            <?php } ?>
                
                <label for="sec_question"><b><?php echo $conformedToRecover ? 'Neue ' : '';?>Sicherheitsfrage wählen</b><br>
                    <select id="sec_question" name="sec_question" required>
                        <option value="">Frage wählen...</option>
                        <?php foreach ($sec_questions as $i  => $question) : ?>
                            <option value="<?php echo $i; ?>"><?php echo $question; ?></option>
                        <?php endforeach ?>
                    </select>
                </label>

                <label for="sec_answer"><b><?php echo $conformedToRecover ? 'Neue ' : '';?>Sicherheitsfrage Antwort</b><br>
                    <input type="text" id="sec_answer" name="sec_answer" placeholder="Sicherheitsfrage Antwort" required>
                </label>

            <?php if ($conformedToRecover) { ?>
                <input type="submit" value='Zurücksetzen' name='reset_user'>
            <?php }else{ ?>
                <input type="submit" value='Speichern' name='recover_user'>
            <?php } ?>
        </form>
    </section>
</body>
</html>