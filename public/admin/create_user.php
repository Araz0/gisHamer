<!DOCTYPE html>
<html lang="de">

<?php 
    $pagetitle = "User erstellen | Gishamer";
    require "../parts/head.php";
    
    // if a normal user trys to create an admin account
    // allow only logged in admins to create an account OR if its Init phase
    allowAdminOnlyOrInitPhase();

    if (isset($_POST['create_user'])) {
        $user_username = $_POST['user_username'];
        $user_password_1 = $_POST['user_password_1'];
        $user_password_2 = $_POST['user_password_2'];
        $sec_question = $_POST['sec_question'];
        $sec_answer = $_POST['sec_answer'];

        if ($user_password_1 != $user_password_2) {
            array_push($errors, "Passwörter müssen übereinstimmen!");
        }
        if (empty($errors)) {
            createtUser($user_username, $user_password_1, $sec_question, $sec_answer);
            header("Location: /login.php");
        }
    }
?>

<body>
    <?php require "../parts/nav.php"; ?>
    <h1>User erstellen</h1>
    <section>
        <?php include('../parts/popups.php'); ?>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="user_username"><b>Username</b> (a-z0-9A-Z.-_)<br>
                <input type="text" id="user_username" name="user_username" placeholder="Username" pattern="<?php echo substr($usernameRegex, 1, -1); ?>" required>
            </label>
            
            <label for="user_password_1"><b>Passwort</b><br>
                <input type="password" id="user_password_1" name="user_password_1" placeholder="Passwort" required>
            </label>

            <label for="user_password_2"><b>Passwort wiederholen</b><br>
                <input type="password" id="user_password_2" name="user_password_2" placeholder="Passwort wiederholen" required>
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
            
            <input type="submit" value='Speichern' name='create_user'>
        </form>
    </section>
</body>
</html>