<!DOCTYPE html>
<html lang="de">

<?php
$pagetitle = "Category " . $_GET["cid"] . " | Gishamer";
require "./parts/head.php";
$category_id = $_GET["cid"];
$maincategory = getCategoryById($category_id);
if ($maincategory->id == null) { // check if enterd maincategory does not exists
    header("Location: /");
}



function printCategory($category)
{
    $category_id = $_GET["cid"];
    //if the category is defined
    if ($category->id) {
        //get all entries and sub-categories of this category:
        $entries = getEntriesByCategoryId($category->id);
        $subCategories = getSubCategoriesByCategoryId($category->id);
?>
        <!-- input and label for the current category to enable toggling view of children -->
        <input type="checkbox" id="c<?php echo $category->id; ?>" />
        <label for="c<?php echo $category->id; ?>" class="tree_label">
            <div class="tree_label__actions">
                <?php echo $category->title; ?>
                <?php 
                    if (userIsLoggedIn()) {
                ?>
                <div  class="tree_label__actions">
                        <a href="/admin/manage_entry.php?mid=<?php echo $category_id; ?>&pid=<?php echo $category->id; ?>">
                            <img src="/media/add.svg" alt="add"></img>
                        </a>
                        <form action="/admin/manage_entry.php?cid=<?php echo $category->id;  ?>" method="post" onsubmit="return confirm('Do you really want to delete this category?');">
                            <button type="submit" name='delete_category' class="news-card__actions__remove">
                                <svg viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.1752 1.7H10.2002V1.275C10.2002 0.57205 9.62815 0 8.9252 0H7.2252C6.52225 0 5.9502 0.57205 5.9502 1.275V1.7H2.9752C2.27225 1.7 1.7002 2.27205 1.7002 2.975V3.825C1.7002 4.3792 2.0555 4.8518 2.5502 5.0269V15.725C2.5502 16.4279 3.12225 17 3.8252 17H12.3252C13.0281 17 13.6002 16.4279 13.6002 15.725V5.0269C14.0949 4.8518 14.4502 4.3792 14.4502 3.825V2.975C14.4502 2.27205 13.8781 1.7 13.1752 1.7ZM6.8002 1.275C6.8002 1.0404 6.9906 0.85 7.2252 0.85H8.9252C9.1598 0.85 9.3502 1.0404 9.3502 1.275V1.7H6.8002V1.275ZM12.3252 16.15H3.8252C3.5906 16.15 3.4002 15.9596 3.4002 15.725V5.1H12.7502V15.725C12.7502 15.9596 12.5598 16.15 12.3252 16.15ZM13.6002 3.825C13.6002 4.0596 13.4098 4.25 13.1752 4.25H2.9752C2.7406 4.25 2.5502 4.0596 2.5502 3.825V2.975C2.5502 2.7404 2.7406 2.55 2.9752 2.55H13.1752C13.4098 2.55 13.6002 2.7404 13.6002 2.975V3.825Z" fill="#777777"/>
                                    <path d="M10.6252 5.95C10.3906 5.95 10.2002 6.1404 10.2002 6.375V14.875C10.2002 15.1096 10.3906 15.3 10.6252 15.3C10.8598 15.3 11.0502 15.1096 11.0502 14.875V6.375C11.0502 6.1404 10.8598 5.95 10.6252 5.95Z" fill="#777777"/>
                                    <path d="M8.07539 5.95C7.84079 5.95 7.65039 6.1404 7.65039 6.375V14.875C7.65039 15.1096 7.84079 15.3 8.07539 15.3C8.30999 15.3 8.50039 15.1096 8.50039 14.875V6.375C8.50039 6.1404 8.30999 5.95 8.07539 5.95Z" fill="#777777"/>
                                    <path d="M5.52461 5.95C5.29001 5.95 5.09961 6.1404 5.09961 6.375V14.875C5.09961 15.1096 5.29001 15.3 5.52461 15.3C5.75921 15.3 5.94961 15.1096 5.94961 14.875V6.375C5.94961 6.1404 5.75921 5.95 5.52461 5.95Z" fill="#777777"/>
                                </svg>
                            </button>
                        </form>
                </div>
                <?php 
                }
                ?>
            </div>
        </label>
        <ul>
            <?php
            // 1):  if category has at least one entry or more, display them:
            if ($entries[0]->id) {
                foreach ($entries as $entry) {
                    echo '<li><span class="tree_label">'. $entry->title .'</span></li>';
                }
            }
            // 2): if category has at least one sub-category or more, print recursively inside an <li> tag to keep it as an item of this category:
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
        <h1><?php echo $maincategory->title; ?></h1>


        <ul class="tree">
            <?php
            printCategory($maincategory);
            ?>

        </ul>
    </section>
</body>

</html>