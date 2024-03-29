<!DOCTYPE html>
<html lang="de">
<?php
// MANAGE SUBCATEGORIES AND LINK ENTRIES
$pagetitle = "Eintrag managen | Gishamer";
require "../parts/head.php";

if (!userIsLoggedIn()) {
    header("Location: /admin/login.php");
}

$_preview_image = "/media/thumbnail_fallback.jpg";
$image_input = "entry_thumbnail";
$entry_thumbnail = $_preview_image;

//--------CATEGORIES--------//
//set when creating a new one
$category_id = $_GET["pid"];
$maincategory_id = $_GET["mid"];
$maincategory = getCategoryById($maincategory_id);
$parentcategory = getCategoryById($category_id);

//default, set if edit an existing category
$category_title = "";
$parentcategory_title = $parentcategory->title;

//set when updating a category
$category_id_edit = $_GET["cid"];

//on update
if (isset($category_id_edit)) {
    $category = getCategoryById($category_id_edit);
    if ($category->id != $category_id_edit) {
        header("Location: /404.php");
        die();
    }
    $category_title = $category->title;
    $parentcategory_edit = getCategoryById($category->category_id);
    $parentcategory_title = $parentcategory_edit->title;
}

if (isset($_POST['create_sub_category'])) {
    $category_name = $_POST['category_name'];
    $parent_category_id = $_POST['parent_category_id'];

    if (empty($errors)) {
        createCategory($category_name, null, "sub_category", $maincategory_id, $parent_category_id);
        header('Location: /category.php?cid=' . $maincategory_id);
    }
}

if (isset($_POST['delete_category'])) {
    $category_id = $_GET["cid"];
    if (empty($errors)) {
        deleteCategory($category_id);
        header('Location: /category.php?cid=' . $maincategory_id);
        die();
    }
}

if (isset($_POST['update_category'])) {
    $category_name = $_POST['category_name'];
    $category_id = $_GET["cid"];
    if (empty($errors)) {
        updateCategory($category_id, $category_name);
        header('Location: /category.php?cid=' . $maincategory_id);
        die();
    }
}

//---------LINK ENTRY--------//

/**
 * Currently, I am doing a dynamic drop-down using PHP. But I have some issues in it. I can't figure it out. It doesn't retrieve the 2nd dropdown values. I did it like below. What I want is when we select an ItemName, The brand names should retrieve to the 2nd dropdown
 */

//set when updating a link entry
$entry_id_edit = $_GET["eid"];

//on update
if (isset($entry_id_edit)) {
    $entry = getLinkEntryById($entry_id_edit);
    if ($entry->id != $entry_id_edit) {
        header("Location: /404.php");
        die();
    }
    $entry_title = $entry->title;
    $entry_link = $entry->link;
    $entry_text = $entry->info;
    $color = $entry->color;
    $entry_thumbnail = $entry->thumbnail;
    $parentcategory_edit = getCategoryById($entry->category_id);
    $parentcategory_title = $parentcategory_edit->title;
}

if (isset($_POST['create_entry'])) {
    $parent_category_id = $_POST['parent_category_id'];
    $entry_title = $_POST['entry_title'];
    $entry_link = $_POST['entry_link'];
    $entry_text = $_POST['entry_text'];
    $color = $_POST['color'];

    $encoded_path = pg_escape_string($entry_link);

    $entry_thumbnail = uploadToStorage(array('jpeg', 'jpg', 'png', 'svg'), $storage_folder, array(basename($_FILES[$image_input]['name']), $_FILES[$image_input]['tmp_name'], $_FILES[$image_input]['size'], $_FILES[$image_input]['type'], $_FILES[$image_input]['error']));
    if ($entry_thumbnail == null || $entry_thumbnail == -1) {
        $entry_thumbnail = $_preview_image;
    }

    if (empty($errors)) {
        createLinkEntry($entry_title, $encoded_path, $entry_text, $color, $entry_thumbnail, $parent_category_id);
        header('Location: /category.php?cid=' . $maincategory_id);
    }
}

if (isset($_POST['delete_entry'])) {
    $entry_id = $_GET["eid"];
    if (empty($errors)) {
        deleteLinkEntry($entry_id);
        header('Location: /category.php?cid=' . $maincategory_id);
        die();
    }
}

if (isset($_POST['update_entry'])) {
    $entry_title = $_POST['entry_title'];
    $entry_link = $_POST['entry_link'];
    $entry_text = $_POST['entry_text'];
    $color = $_POST['color'];
    if (!empty($_FILES[$image_input]['name'])) {
        $entry_thumbnail = uploadToStorage(array('jpeg', 'jpg', 'png', 'svg'), $storage_folder, array(basename($_FILES[$image_input]['name']), $_FILES[$image_input]['tmp_name'], $_FILES[$image_input]['size'], $_FILES[$image_input]['type'], $_FILES[$image_input]['error']));
        if ($entry_thumbnail == null || $entry_thumbnail == -1) {
            $entry_thumbnail = $_preview_image;
        }
    }

    $encoded_path = pg_escape_string($entry_link);

    if (empty($errors)) {
        updateLinkEntry($entry_title, $encoded_path, $entry_text, $color, $entry_thumbnail, $entry_id_edit);
        header('Location: /category.php?cid=' . $maincategory_id);
        die();
    }
}
?>

<body>
    <?php require "../parts/nav.php"; ?>
    <h1><?php echo (isset($category_id_edit) || isset($entry_id_edit)) ? 'Eintrag bearbeiten' : ('Neuer Eintrag in ' . $parentcategory_title)  ?></h1>
    <?php if (!isset($category_id_edit)) { ?><button onclick="toggleType()" id="toggle_type" class="toggle toggle--on">
            <div class="manage_entry_toggle">
                <div>KATEGORIE</div>
                <div>FILE</div>
            </div>
        </button><?php } ?>
    <section id="create_category">
        <form action="" method="post" enctype="multipart/form-data" <?php if (isset($category_id_edit)) { ?>onsubmit="return confirm('Willst du die Änderungen wirklich speichern?');" <?php } ?>>
            <input type="hidden" name="parent_category_id" value="<?php echo $category_id; ?>" id="parent_category_id" required>
            <!-- <label for="parent_category_name"><b>Parent-Kategorie</b><br>
                <input readonly type="text" name="parent_category_name" value="<?php echo $parentcategory_title ?>" id="parent_category_name" required>
            </label> -->
            <label for="category_name"><b>Titel</b><br>
                <input type="text" name="category_name" placeholder="Titel der Kategorie" value="<?php echo $category_title ?>" id="category_name" required>
            </label>

            <?php if (isset($category_id_edit)) { ?>
                <input type="submit" value='Speichern' name='update_category'>
            <?php } else { ?>
                <input type="submit" value='Speichern' name='create_sub_category'>
            <?php } ?>
        </form>
    </section>
    <section id="create_entry" style="display:none;">
        <form action="" method="post" enctype="multipart/form-data" <?php if (isset($entry_id_edit)) { ?>onsubmit="return confirm('Willst du die Änderungen wirklich speichern?');" <?php } ?>>
            <input type="hidden" name="parent_category_id" value="<?php echo $category_id; ?>" id="parent_category_id" required>
            <!-- <label for="parent_category_name"><b>Parent-Kategorie</b><br>
                <input readonly type="text" name="parent_category_name" value="<?php echo $parentcategory_title ?>" id="parent_category_name" required>
            </label> -->
            <label for="entry_title"><b>Titel</b><br>
                <input type="text" name="entry_title" placeholder="Titel" value="<?php echo $entry_title ?>" id="entry_title" required>
            </label>
            <label for="entry_link"><b>Link</b><br>
                <input type="text" name="entry_link" placeholder="Link" value="<?php echo $entry_link ?>" id="entry_link" required>
            </label>
            <label for="entry_text"><b>Info</b><br>
                <textarea id="entry_text" name="entry_text" rows="10" placeholder="Vorschau Info" required><?php echo $entry_text; ?></textarea>
            </label>
            <label for="color"><b>Farbe</b><br>
                <?php echo ($entry->color == "main_category") ? 'checked="true"' : ''; ?>
                <select name="color" id="color" list="presets" required>>
                    <?php
                    $colors = array();
                    $colors[0] = (object) array('color' => '#1abc9c', 'name' => 'Teal');
                    $colors[1] = (object) array('color' => '#27ae60', 'name' => 'Green');
                    $colors[2] = (object) array('color' => '#3498db', 'name' => 'Blue');
                    $colors[3] = (object) array('color' => '#8e44ad', 'name' => 'Purple');
                    $colors[4] = (object) array('color' => '#c0392b', 'name' => 'Red');
                    $colors[5] = (object) array('color' => '#e67e22', 'name' => 'Orange');
                    $colors[6] = (object) array('color' => '#f1c40f', 'name' => 'Yellow');
                    $colors[7] = (object) array('color' => '#7f8c8d', 'name' => 'Gray');
                    $colors[8] = (object) array('color' => '#2c3e50', 'name' => 'Dark');

                    foreach ($colors as $color) {
                        $selected = ($entry->color == $color->color) ? 'selected="true"' : '';
                        echo '<option value="' . $color->color . '" style="background-color:' . $color->color . '" ' . $selected . '>' . $color->name . '</option>';
                    }
                    ?>
                </select>
            </label>

            </label>
            <label for="entry_thumbnail"><b>Vorschau Bild</b><br>
                <img class="form_thumbnail" id="form_thumbnail" src="<?php echo $entry_thumbnail; ?>" alt="Vorschau Bild"><br>
                <input type="file" name="entry_thumbnail" id="entry_thumbnail" max-size="100000" accept="image/*,.jpg">
            </label>

            <?php if (isset($entry_id_edit)) { ?>
                <input type="submit" value='Speichern' name='update_entry'>
            <?php } else { ?>
                <input type="submit" value='Speichern' name='create_entry'>
            <?php } ?>
        </form>
    </section>
</body>

</html>
<script type="text/javascript">
    var createCategory = document.getElementById("create_category");
    var createEntry = document.getElementById("create_entry");

    function toggleType() {
        if (createCategory.style.display === "none") {
            createCategory.style.display = "block";
            createEntry.style.display = "none";
        } else {
            createCategory.style.display = "none";
            createEntry.style.display = "block";
        }
        var toggleType = document.getElementById("toggle_type");
        if (toggleType.classList.contains("toggle--on")) {
            toggleType.classList.remove("toggle--on");
            toggleType.classList.add("toggle--off");
        } else {
            toggleType.classList.add("toggle--on");
            toggleType.classList.remove("toggle--off");
        }
    }

    //get param from url
    //if param has eid --> remove style from create category and add style to crate entry
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const entry = urlParams.get('eid')
    if (entry) {
        toggleType();
    }

    // on change of image --> change preview image
    addPreviewSupport('entry_thumbnail', 'form_thumbnail');
</script>