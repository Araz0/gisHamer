<!DOCTYPE html>
<html lang="de">
<?php 
    $pagetitle = "Manage Entries | Gishamer";
    require "../parts/head.php";
    
    if(!userIsLoggedIn()){
        header("Location: /admin/login.php");
    }

    $_preview_image = "/media/thumbnail_fallback.jpg";
    $image_input = "entry_thumbnail";

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
        if ($category->id != $category_id_edit){
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
            createCategory($category_name, null, "sub_category", $parent_category_id);
            header('Location: /category.php?cid='.$maincategory_id);
        }  
    }

    if (isset($_POST['delete_category'])) {
        $category_id = $_GET["cid"];
        if (empty($errors)) {
            deleteCategory($category_id);
            header("Location: /");
            die();
        }
    }

    if (isset($_POST['update_category'])) {
        $category_name = $_POST['category_name'];
        $category_id = $_GET["cid"];
        if (empty($errors)) {
            updateCategory($category_id,$category_name);
            header("Location: /");
            //todo redirect to main category
            die();
        }
    }

    //--------LINK ENTRY--------//
    if (isset($_POST['create_entry'])) {
        $parent_category_id = $_POST['parent_category_id'];
        $entry_title = $_POST['entry_title'];
        $entry_link = $_POST['entry_link'];
        $entry_text = $_POST['entry_text'];
        $color = $_POST['color'];

        $entry_thumbnail = uploadToStorage(array('jpeg','jpg','png', 'svg'), $storage_folder, array(basename($_FILES[$image_input]['name']), $_FILES[$image_input]['tmp_name'], $_FILES[$image_input]['size'], $_FILES[$image_input]['type'], $_FILES[$image_input]['error']));
        if ($entry_thumbnail == null || $entry_thumbnail == -1) { $entry_thumbnail = $_preview_image; }
        
        if (empty($errors)) {
            createLinkEntry($entry_title, $entry_link, $entry_text, $color, $entry_thumbnail, $parent_category_id);
            header('Location: /');
        }  
    }
?>

<body>
    <?php require "../parts/nav.php"; ?>
    <h1><?php echo isset($category_id_edit) ? 'Bearbeiten' : ('Neuer Eintrag in '.$maincategory->title)  ?></h1>
    <?php if (!isset($category_id_edit)) { ?><button onclick="toggleType()" id="toggle_type" class="toggle toggle--on"></button><?php } ?>
    <section id="create_category">
        <form action="" method="post" enctype="multipart/form-data" <?php if (isset($category_id_edit)) { ?>onsubmit="return confirm('Are you sure about this change?');"<?php } ?>>
            <input type="hidden" name="parent_category_id" value="<?php echo $category_id; ?>" id="parent_category_id" required>
            <label for="parent_category_name"><b>Parent-Kategorie</b><br>
                <input readonly type="text" name="parent_category_name" value="<?php echo $parentcategory_title ?>" id="parent_category_name" required>
            </label>
            <label for="category_name"><b>Titel</b><br>
                <input type="text" name="category_name" placeholder="Titel der Kategorie" value="<?php echo $category_title ?>" id="category_name" required>
            </label>

            <?php if (isset($category_id_edit)) { ?>
                <input type="submit" value='Speichern' name='update_category'>
            <?php }else{ ?>
                <input type="submit" value='Speichern' name='create_sub_category'>
            <?php } ?>
        </form>
    </section>
    <section id="create_entry" style="display:none;">
        <form action="" method="post" enctype="multipart/form-data" <?php if (isset($entry_id_edit)) { ?>onsubmit="return confirm('Are you sure about this change?');"<?php } ?>>
            <input type="hidden" name="parent_category_id" value="<?php echo $category_id; ?>" id="parent_category_id" required>
            <label for="parent_category_name"><b>Parent-Kategorie</b><br>
                <input readonly type="text" name="parent_category_name" value="<?php echo $parentcategory_title ?>" id="parent_category_name" required>
            </label>
            <label for="entry_title"><b>Titel</b><br>
                <input type="text" name="entry_title" placeholder="Titel" value="<?php echo $entry_title ?>" id="entry_title" required>
            </label>
            <label for="entry_link"><b>Link</b><br>
                <input type="text" name="entry_link" placeholder="Titel" value="<?php echo $entry_link ?>" id="entry_link" required>
            </label>
            <label for="entry_text"><b>Info</b><br>
                <textarea id="entry_text" name="entry_text" rows="10" placeholder="Vorschau Info" required><?php echo $entry_text; ?></textarea>
            </label>
            <label for="color"><b>Farbe</b><br>
                <input type="color" name="color" id="color" list="presets" value="#e1c9f8" required></label>
                <datalist id="presets">
                    <option value="#e1c9f8">pink</option>
                    <option value="#988dae">violet</option>
                    <option value="#f8dcc9">orange</option>
                    <option value="#ae9a8d">brown</option>
                    <option value="#e4f8c9">green</option>
                </datalist>
            </label>
            <label for="entry_thumbnail"><b>Vorschau Bild</b><br>
                <img class="form_thumbnail" src="<?php echo $_preview_image; ?>" alt="Preview Image"><br>
                <input type="file" name="entry_thumbnail" id="entry_thumbnail" max-size="100000" accept="image/*,.jpg">
            </label>

            <?php if (isset($entry_id_edit)) { ?>
                <input type="submit" value='Speichern' name='update_entry'>
            <?php }else{ ?>
                <input type="submit" value='Speichern' name='create_entry'>
            <?php } ?>
        </form>
    </section>
</body>
</html>

<script type="text/javascript">
    function toggleType() {
        var createCategory = document.getElementById("create_category");
        var createEntry = document.getElementById("create_entry");
        if (createCategory.style.display === "none") {
            createCategory.style.display = "block";
            createEntry.style.display = "none";
        } else {
            createCategory.style.display = "none";
            createEntry.style.display = "block";
        }
        var toggleType = document.getElementById("toggle_type");
        if(toggleType.classList.contains("toggle--on")){
            toggleType.classList.remove("toggle--on");
            toggleType.classList.add("toggle--off");
        }
        else{
            toggleType.classList.add("toggle--on");
            toggleType.classList.remove("toggle--off");
        }
    }
</script>