<!DOCTYPE html>
<html lang="de">

<?php 
    $pagetitle = "Admin | Gishamer";
    require "../parts/head.php";
    
    if(!userIsLoggedIn()){
        header("Location: /admin/login.php");
    }
    
?>

<body>
    <?php require "../parts/nav.php"; ?>
    <a href="/admin/create_main_category.php">Hauptkategorie erstellen</a>
    <br>
    <a href="/admin/manage_entry.php">Eintrag erstellen</a>
    <br>
    <a href="/admin/create_user.php">Neue Admin Account erstellen</a>
    <br>
    <a href="/admin/news_post.php">Neue Eintrag erstellen</a>
</body>
</html>