<!DOCTYPE html>
<html lang="de">
<?php 
    $pagetitle = "Create Main Category | Gishamer";
    require "../parts/head.php";
 
    if(!userIsLoggedIn()){
        header("Location: /admin/login.php");
    }

    $icon_input = "main_category_icon";

    if (isset($_POST['create_main_category'])) {
        $main_category_name = $_POST['main_category_name'];

        $main_category_icon = uploadToStorage(array('jpeg','jpg','png', 'svg'), $storage_folder, array(basename($_FILES[$icon_input]['name']), $_FILES[$icon_input]['tmp_name'], $_FILES[$icon_input]['size'], $_FILES[$icon_input]['type'], $_FILES[$icon_input]['error']));
        if ($main_category_icon == null || $main_category_icon == -1) { /*echo implode("\n ",$errors); exit();*/ $main_category_icon = $icon_fallback; }
        
        if (empty($errors)) {
            createCategory($main_category_name, $main_category_icon, "main_category");
            header('Location: /');
        }
        
    }
?>

<body>
    <?php require "../parts/nav.php"; ?>
    <section>
        <h1>Hauptkategorie erstellen</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="main_category_name"><b>Titel</b><br>
                <input type="text" name="main_category_name" placeholder="Titel der Hauptkategorie" value="" id="main_category_name" required>
            </label>
            
            <label for="main_category_icon"><b>Icon</b><br>
                <input type="file" name="main_category_icon" id="main_category_icon" max-size="1000" accept="image/*,.jpg" required>
            </label>

            <input type="submit" value='Speichern' name='create_main_category'>
        </form>
    </section>
</body>
</html>