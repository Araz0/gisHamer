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
    //if the category is defined
    if ($category->id) {
        //get all entries and sub-categories of this category:
        $entries = getEntriesByCategoryId($category->id);
        $subCategories = getSubCategoriesByCategoryId($category->id);
?>
        <!-- input and label for the current category to enable toggling view of children -->
        <input type="checkbox" id="c<?php echo $category->id; ?>" />
        <label for="c<?php echo $category->id; ?>" class="tree_label"><?php echo $category->title; ?></label>
        <ul>
            <?php
            // 1):  if category has at least one entry or more, display them:
            if ($entries[0]->id) {
                foreach ($entries as $entry) {
                    echo '<li><span class="tree_label">'. $entry->title .'</span></li>';
                }
            }
            // 2): if category has at leastr one sub-category or more, print recursively inside an <li> tag to keep it as an item of this category:
            if ($subCategories[0]->id) {
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