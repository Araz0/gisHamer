<!DOCTYPE html>
<html lang="de">
<?php
$pagetitle = "Hauptkategorie erstellen | Gishamer";
require "../parts/head.php";

if (!userIsLoggedIn()) {
    header("Location: /admin/login.php");
}

$icon_input = "main_category_icon";
$icon_fallback = "/media/icon_fallback.png";

$title = "";
$category_id = null;

//UPDATE CATEGORY
if (isset($_GET["cid"])) {
    $category_id = $_GET["cid"];
}

if (isset($category_id)) {
    $category = getCategoryById($category_id);
    if ($category->id != $category_id) {
        header("Location: /404.php");
        die();
    }
    $title = $category->title;
    $icon_fallback = $category->icon;
}


if (isset($_POST['create_main_category'])) {
    $main_category_name = $_POST['main_category_name'];
    $main_category_icon = uploadToStorage(array('jpeg', 'jpg', 'png', 'svg'), $storage_folder, array(basename($_FILES[$icon_input]['name']), $_FILES[$icon_input]['tmp_name'], $_FILES[$icon_input]['size'], $_FILES[$icon_input]['type'], $_FILES[$icon_input]['error']));
    if ($main_category_icon == null || $main_category_icon == -1) {
        $main_category_icon = $icon_fallback;
    }

    if (empty($errors)) {
        createCategory($main_category_name, $main_category_icon, "main_category");
        header('Location: /');
    }
}

if (isset($_POST['update_main_category'])) {
    $category_id = $_GET["cid"];

    $category_name = $_POST['main_category_name'];
    $main_category_icon = uploadToStorage(array('jpeg', 'jpg', 'png', 'svg'), $storage_folder, array(basename($_FILES[$icon_input]['name']), $_FILES[$icon_input]['tmp_name'], $_FILES[$icon_input]['size'], $_FILES[$icon_input]['type'], $_FILES[$icon_input]['error']));
    if ($main_category_icon == null || $main_category_icon == -1) {
        $main_category_icon = $icon_fallback;
    }

    if (empty($errors)) {
        updateMainCategory($category_name, $main_category_icon, $category_id);
        header('Location: /category.php?cid=' . $category_id);
        die();
    }
}
?>

<body>
    <?php require "../parts/nav.php"; ?>
    <section>
        <h1><?php echo isset($category_id) ? 'Hauptkategorie bearbeiten' : 'Neue Hauptkategorie'  ?></h1>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="main_category_name"><b>Titel</b><br>
                <input type="text" name="main_category_name" placeholder="Titel der Hauptkategorie" value="<?php echo $title ?>" id="main_category_name" required>
            </label>

            <label for="main_category_icon"><b>Icon</b><br>
                <img class="form_tumbnail_icon" id="form_tumbnail_icon" src="<?php echo $icon_fallback ?>" alt="News Post Thumbnail Image"><br>
                <input type="file" name="main_category_icon" id="main_category_icon" max-size="1000" accept="image/*,.jpg">
            </label>

            <?php if (isset($category_id)) { ?>
                <input type="submit" value='Speichern' name='update_main_category'>
            <?php } else { ?>
                <input type="submit" value='Speichern' name='create_main_category'>
            <?php } ?>
        </form>
    </section>
    <script type="text/javascript">
        addPreviewSupport('main_category_icon', 'form_tumbnail_icon');
    </script>
</body>

</html>