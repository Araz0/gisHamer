<!DOCTYPE html>
<html lang="de">

<?php
$pagetitle = "Category " . $_GET["cid"] . " | Gishamer";
require "./parts/head.php";
$category_id = $_GET["cid"];
$category = getCategoryById($category_id);
if ($category->id == null) { // check if enterd category does not exists
    header("Location: /");
}

$entries = getEntriesByCategoryId($category_id);
?>

<body>
    <?php require "parts/nav.php"; ?>
    <section>
        <h1><?php echo $category->title; ?></h1>
        <?php
        // if ($entry->id) {
        //     foreach($entries as $entry){
        //         echo $entry->title;
        //     }
        // }
        ?>
        <ul class="tree">
            <li>
                <input type="checkbox" checked="checked" id="c5" />
                <label class="tree_label" for="c5">Level 0</label>
                <ul>
                    <li>
                        <input type="checkbox" id="c6" />
                        <label for="c6" class="tree_label">Level 1</label>
                        <ul>
                            <li><span class="tree_label">Level 2</span></li>
                            <li><span class="tree_label">Level 2</span></li>
                        </ul>
                    </li>
                    <li>
                        <input type="checkbox" id="c7" />
                        <label for="c7" class="tree_label">Level 1</label>
                        <ul>
                            <li><span class="tree_label">Level 2</span></li>
                            <li>
                                <input type="checkbox" id="c8" />
                                <label for="c8" class="tree_label">Level 2</label>
                                <ul>
                                    <li><span class="tree_label">Level 3</span></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
</body>

</html>