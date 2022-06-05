<!DOCTYPE html>
<html lang="de">
<?php 
    $pagetitle = "Create Sub Category | Gishamer";
    require "../parts/head.php";

    if(!userIsLoggedIn()){
        header("Location: /admin/login.php");
    }

    if (isset($_POST['create_sub_category'])) {
        $category_name = $_POST['category_name'];
        $parent_category_id = $_POST['parent_category_id'];

        if (empty($errors)) {
            createSubCategory($category_name, $parent_category_id);
            header('Location: /');
        }
        
    }
?>

<body>
    <?php require "../parts/nav.php"; ?>
    <section>
        <h1>Kategorie hinzufügen</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="parent_category_id" value="1" id="parent_category_id" required>

            <label for="category_name"><b>Titel</b><br>
                <input type="text" name="category_name" placeholder="Titel der Kategorie" value="" id="category_name" required>
            </label>

            <input type="submit" value='Speichern' name='create_sub_category'>
        </form>
    </section>
</body>
</html>