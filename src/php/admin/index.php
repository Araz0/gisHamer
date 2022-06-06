<!DOCTYPE html>
<html lang="de">

<?php 
    if(!userIsLoggedIn()){
        header("Location: /admin/login.php");
    }
    $pagetitle = "Admin | Gishamer";
    require "../parts/head.php";
    
?>

<body>
    <?php require "../parts/nav.php"; ?>
    <a href="/admin/create_main_category.php">Hauptkategorie erstellen</a>
    <br>
    <a href="/admin/create_sub_category.php">Kategorie erstellen</a>
    <br>
    <a href="/admin/create_user.php">Neue Admin Account erstellen</a>
</body>
</html>