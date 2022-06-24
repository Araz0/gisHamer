<!DOCTYPE html>
<html lang="de">
<?php 
    $pagetitle = "Create Sub Category | Gishamer";
    require "../parts/head.php";
    
    if(!userIsLoggedIn()){
        header("Location: /admin/login.php");
    }

    $category_id = $_GET["pid"];
    $maincategory_id = $_GET["mid"];

    $maincategory = getCategoryById($maincategory_id);
    $parentcategory = getCategoryById($category_id);

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
?>

<body>
    <?php require "../parts/nav.php"; ?>
    <h1>Neuer Eintrag in <?php echo $maincategory->title; ?></h1>
    <button onclick="toggleType()" id="toggle_type" class="toggle toggle--on"></button>
    <section id="create_category">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="parent_category_id" value="<?php echo $category_id; ?>" id="parent_category_id" required>
            <label for="parent_category_name"><b>Parent-Kategorie</b><br>
                <input readonly type="text" name="parent_category_name" value="<?php echo $parentcategory->title; ?>" id="parent_category_name" required>
            </label>
            <label for="category_name"><b>Titel</b><br>
                <input type="text" name="category_name" placeholder="Titel der Kategorie" value="" id="category_name" required>
            </label>

            <input type="submit" value='Speichern' name='create_sub_category'>
        </form>
    </section>
    <section id="create_entry" style="display:none;">
        <h2>TODO: Eintrag </h2>
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

    $('.toggle').click(function(e) {
        var toggle = this;
        
        e.preventDefault();
        
        $(toggle).toggleClass('toggle--on')
                .toggleClass('toggle--off')
                
    });
</script>