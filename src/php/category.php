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



function printCategory($category)
{
    //print the entries
    $entries = getEntriesByCategoryId($category->id);
    $subCategories = getSubCategoriesByCategoryId($category->id);
    if ($category->id) { //if its not null
?>
        <input type="checkbox" id="c<?php echo $category->id; ?>" />
        <label for="c<?php echo $category->id; ?>" class="tree_label"><?php echo $category->title; ?></label>
        <ul>
            <?php
            if ($entries[0]->id) { //if has one entry or more
                foreach ($entries as $entry) {
            ?>
                    <li><span class="tree_label"><?php echo $entry->title; ?></span></li>
            <?php
                }
            }
            if ($subCategories[0]->id) { //if has one sub category or more
                foreach ($subCategories as $sub_category) {
                    echo "<li>";
                    printCategory($sub_category);
                    echo "</li>";
                }
            }
            ?>
        </ul>
<?php
    }
}
?>

<body>
    <?php require "parts/nav.php"; ?>
    <section>
        <h1><?php echo $category->title; ?></h1>


        <ul class="tree">
            <?php
            printCategory($category);
            ?>

        </ul>
    </section>
</body>

</html>