<!DOCTYPE html>
<html lang="de">
<?php 
    $pagetitle = "Create Main Category";
    require '../functions.php';
    require "../parts/head.php";
 
    if (isset($_POST['create_main_category'])) {
        $main_category_name = $_POST['main_category_name'];

        $_inputName = "main_category_icon";
        $input_array = array(basename($_FILES[$_inputName]['name']), $_FILES[$_inputName]['tmp_name'], $_FILES[$_inputName]['size'], $_FILES[$_inputName]['type'], $_FILES[$_inputName]['error']);
        $main_category_icon = fileUpload( $input_array, $storage_folder, array('jpeg','jpg','png','svg'));
        if ($main_category_icon == null) { echo implode("\n ",$errors); exit(); }
        if (empty($errors)) {
            createMainCategory($main_category_name);
        }
        header('Location: /');
    }
?>

<body>
    <?php require "../parts/nav.php"; ?>
    <section>
        <h1>Hauptkategorie erstellen</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="main_category_name"><b>Titel</b></label>
            <input type="text" name="main_category_name" placeholder="Titel der Hauptkategorie" value="" id="main_category_name" required>
            
            <label for="main_category_icon"><b>Icon</b></label>
            <input type="file" name="main_category_icon" id="main_category_icon" max-size="1000" accept="image/*,.jpg" required>

            <input type="submit" value='Speichern' name='create_main_category'>
        </form>
    </section>
</body>
</html>