<!DOCTYPE html>
<html lang="de">

<?php
$pagetitle = "Hauptkategorie ".$_GET["cid"]." | Gishamer";
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
        <input type="checkbox" id="c<?php echo $category->id; ?>" <?php echo ($category->type == "main_category") ? 'checked="true"' : ''; ?> />
        <label for="c<?php echo $category->id; ?>" class="tree_label">
            <div class="tree_label__body">
                <?php echo $category->title; ?>
                <?php
                if (userIsLoggedIn()) {
                ?>
                    <div class="tree_label__actions">
                        <a href="/admin/manage_entry.php?mid=<?php echo $category_id; ?>&pid=<?php echo $category->id; ?>">
                            <img src="/media/add.svg" alt="add"></img>
                        </a>
                        <a href="/admin/manage_entry.php?cid=<?php echo  $category->id; ?>">
                            <svg viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.2384 0.761602C15.7607 0.283902 15.1257 0.0212517 14.45 0.0212517C13.7742 0.0212517 13.1393 0.283902 12.6616 0.761602L1.82406 11.5991C1.77986 11.6433 1.74671 11.696 1.72546 11.7547L0.025459 16.4297C-0.030641 16.5852 0.00760902 16.7586 0.124059 16.8751C0.204809 16.9558 0.313609 16.9992 0.424959 16.9992C0.473409 16.9992 0.522709 16.9907 0.570309 16.9737L5.24531 15.2737C5.30396 15.2524 5.35666 15.2184 5.40086 15.1751L16.2384 4.33755C16.7161 3.85985 16.9787 3.2249 16.9787 2.54915C16.9787 1.8734 16.7161 1.23845 16.2384 0.760752V0.761602ZM4.86621 14.5078L1.13556 15.8644L2.49216 12.1338L11.9 2.72595L14.274 5.1L4.86621 14.5078ZM15.6366 3.7366L14.875 4.4982L12.5009 2.12415L13.2625 1.36255C13.5796 1.0455 14.0012 0.871252 14.4491 0.871252C14.8971 0.871252 15.3187 1.0455 15.6357 1.36255C15.9528 1.6796 16.127 2.1012 16.127 2.54915C16.127 2.9971 15.9528 3.4187 15.6357 3.73575L15.6366 3.7366Z" fill="#777777" />
                            </svg>
                        </a>
                        <form action="/admin/manage_entry.php?cid=<?php echo $category->id;  ?>" method="post" onsubmit="return confirm('Willst du die Kategorie wirklich löschen?');">
                            <button type="submit" name='delete_category'>
                                <svg viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.1752 1.7H10.2002V1.275C10.2002 0.57205 9.62815 0 8.9252 0H7.2252C6.52225 0 5.9502 0.57205 5.9502 1.275V1.7H2.9752C2.27225 1.7 1.7002 2.27205 1.7002 2.975V3.825C1.7002 4.3792 2.0555 4.8518 2.5502 5.0269V15.725C2.5502 16.4279 3.12225 17 3.8252 17H12.3252C13.0281 17 13.6002 16.4279 13.6002 15.725V5.0269C14.0949 4.8518 14.4502 4.3792 14.4502 3.825V2.975C14.4502 2.27205 13.8781 1.7 13.1752 1.7ZM6.8002 1.275C6.8002 1.0404 6.9906 0.85 7.2252 0.85H8.9252C9.1598 0.85 9.3502 1.0404 9.3502 1.275V1.7H6.8002V1.275ZM12.3252 16.15H3.8252C3.5906 16.15 3.4002 15.9596 3.4002 15.725V5.1H12.7502V15.725C12.7502 15.9596 12.5598 16.15 12.3252 16.15ZM13.6002 3.825C13.6002 4.0596 13.4098 4.25 13.1752 4.25H2.9752C2.7406 4.25 2.5502 4.0596 2.5502 3.825V2.975C2.5502 2.7404 2.7406 2.55 2.9752 2.55H13.1752C13.4098 2.55 13.6002 2.7404 13.6002 2.975V3.825Z" fill="#777777" />
                                    <path d="M10.6252 5.95C10.3906 5.95 10.2002 6.1404 10.2002 6.375V14.875C10.2002 15.1096 10.3906 15.3 10.6252 15.3C10.8598 15.3 11.0502 15.1096 11.0502 14.875V6.375C11.0502 6.1404 10.8598 5.95 10.6252 5.95Z" fill="#777777" />
                                    <path d="M8.07539 5.95C7.84079 5.95 7.65039 6.1404 7.65039 6.375V14.875C7.65039 15.1096 7.84079 15.3 8.07539 15.3C8.30999 15.3 8.50039 15.1096 8.50039 14.875V6.375C8.50039 6.1404 8.30999 5.95 8.07539 5.95Z" fill="#777777" />
                                    <path d="M5.52461 5.95C5.29001 5.95 5.09961 6.1404 5.09961 6.375V14.875C5.09961 15.1096 5.29001 15.3 5.52461 15.3C5.75921 15.3 5.94961 15.1096 5.94961 14.875V6.375C5.94961 6.1404 5.75921 5.95 5.52461 5.95Z" fill="#777777" />
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
            ?>
                    <li>
                        <div class="tree_label" 
                            onclick="SpawnDialog('<?php echo $entry->title ?>', '<?php echo $entry->link ?>', '<?php echo $entry->info ?>', '<?php echo $entry->color ?>', '<?php echo $entry->thumbnail ?>')">
                            <div>
                                <?php echo $entry->title ?>
                                <?php
                                if (userIsLoggedIn()) {
                                ?>
                                    <div class="tree_label__actions">
                                        <a href="/admin/manage_entry.php?eid=<?php echo  $entry->id; ?>">
                                            <svg viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M16.2384 0.761602C15.7607 0.283902 15.1257 0.0212517 14.45 0.0212517C13.7742 0.0212517 13.1393 0.283902 12.6616 0.761602L1.82406 11.5991C1.77986 11.6433 1.74671 11.696 1.72546 11.7547L0.025459 16.4297C-0.030641 16.5852 0.00760902 16.7586 0.124059 16.8751C0.204809 16.9558 0.313609 16.9992 0.424959 16.9992C0.473409 16.9992 0.522709 16.9907 0.570309 16.9737L5.24531 15.2737C5.30396 15.2524 5.35666 15.2184 5.40086 15.1751L16.2384 4.33755C16.7161 3.85985 16.9787 3.2249 16.9787 2.54915C16.9787 1.8734 16.7161 1.23845 16.2384 0.760752V0.761602ZM4.86621 14.5078L1.13556 15.8644L2.49216 12.1338L11.9 2.72595L14.274 5.1L4.86621 14.5078ZM15.6366 3.7366L14.875 4.4982L12.5009 2.12415L13.2625 1.36255C13.5796 1.0455 14.0012 0.871252 14.4491 0.871252C14.8971 0.871252 15.3187 1.0455 15.6357 1.36255C15.9528 1.6796 16.127 2.1012 16.127 2.54915C16.127 2.9971 15.9528 3.4187 15.6357 3.73575L15.6366 3.7366Z" fill="#777777" />
                                            </svg>
                                        </a>
                                        <form action="/admin/manage_entry.php?eid=<?php echo $entry->id;  ?>" method="post" onsubmit="return confirm('Willst du diesen Eintrag wirklich löschen?');">
                                            <button type="submit" name='delete_entry'>
                                                <svg viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M13.1752 1.7H10.2002V1.275C10.2002 0.57205 9.62815 0 8.9252 0H7.2252C6.52225 0 5.9502 0.57205 5.9502 1.275V1.7H2.9752C2.27225 1.7 1.7002 2.27205 1.7002 2.975V3.825C1.7002 4.3792 2.0555 4.8518 2.5502 5.0269V15.725C2.5502 16.4279 3.12225 17 3.8252 17H12.3252C13.0281 17 13.6002 16.4279 13.6002 15.725V5.0269C14.0949 4.8518 14.4502 4.3792 14.4502 3.825V2.975C14.4502 2.27205 13.8781 1.7 13.1752 1.7ZM6.8002 1.275C6.8002 1.0404 6.9906 0.85 7.2252 0.85H8.9252C9.1598 0.85 9.3502 1.0404 9.3502 1.275V1.7H6.8002V1.275ZM12.3252 16.15H3.8252C3.5906 16.15 3.4002 15.9596 3.4002 15.725V5.1H12.7502V15.725C12.7502 15.9596 12.5598 16.15 12.3252 16.15ZM13.6002 3.825C13.6002 4.0596 13.4098 4.25 13.1752 4.25H2.9752C2.7406 4.25 2.5502 4.0596 2.5502 3.825V2.975C2.5502 2.7404 2.7406 2.55 2.9752 2.55H13.1752C13.4098 2.55 13.6002 2.7404 13.6002 2.975V3.825Z" fill="#777777" />
                                                    <path d="M10.6252 5.95C10.3906 5.95 10.2002 6.1404 10.2002 6.375V14.875C10.2002 15.1096 10.3906 15.3 10.6252 15.3C10.8598 15.3 11.0502 15.1096 11.0502 14.875V6.375C11.0502 6.1404 10.8598 5.95 10.6252 5.95Z" fill="#777777" />
                                                    <path d="M8.07539 5.95C7.84079 5.95 7.65039 6.1404 7.65039 6.375V14.875C7.65039 15.1096 7.84079 15.3 8.07539 15.3C8.30999 15.3 8.50039 15.1096 8.50039 14.875V6.375C8.50039 6.1404 8.30999 5.95 8.07539 5.95Z" fill="#777777" />
                                                    <path d="M5.52461 5.95C5.29001 5.95 5.09961 6.1404 5.09961 6.375V14.875C5.09961 15.1096 5.29001 15.3 5.52461 15.3C5.75921 15.3 5.94961 15.1096 5.94961 14.875V6.375C5.94961 6.1404 5.75921 5.95 5.52461 5.95Z" fill="#777777" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </li>
            <?php
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
    <script>
        // javascript function to delete .dialog element when onclick on this is clicked
        function deleteDialog(e) {
            if (e.classList.contains("dialog__container__close")) {
                e.parentElement.parentElement.remove();
            } else if (e.classList.contains("dialog")) {
                e.remove();
            }
        }

        //javascript function SpawnDialog() to spawn a diglog with title, link, info, color, and thumbnail of the entry clicked in the tree
        function SpawnDialog(title, link, info, color, thumbnail) {
            var dialog = document.createElement("div");
            dialog.className = "dialog";
            //dialog on click event to delete the dialog
            dialog.onclick = function(e) {
                deleteDialog(e.target);
            };
            dialog.innerHTML = '<div class="dialog__container">' +
                '<svg onclick="deleteDialog(this)" class="dialog__container__close" width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">' +
                '<path d="M12.5 0C5.5875 0 0 5.5875 0 12.5C0 19.4125 5.5875 25 12.5 25C19.4125 25 25 19.4125 25 12.5C25 5.5875 19.4125 0 12.5 0ZM12.5 22.5C6.9875 22.5 2.5 18.0125 2.5 12.5C2.5 6.9875 6.9875 2.5 12.5 2.5C18.0125 2.5 22.5 6.9875 22.5 12.5C22.5 18.0125 18.0125 22.5 12.5 22.5ZM16.9875 6.25L12.5 10.7375L8.0125 6.25L6.25 8.0125L10.7375 12.5L6.25 16.9875L8.0125 18.75L12.5 14.2625L16.9875 18.75L18.75 16.9875L14.2625 12.5L18.75 8.0125L16.9875 6.25Z" />' +
                '</svg>' +
                '<div class="dialog__container__title">' +
                '<h3>' + title + '</h3>' +
                '</div>' +
                '<img src="' + thumbnail + '" alt="' + title + '" class="dialog__container__thumbnail">' +
                '<p class="dialog__container__info">' + info + '</p>' +
                '<div class="dialog__container__actions">' +
                '<a href="' + link + '" class="dialog__container__actions__open">Dokument öffnen</a>' +
                '</div>' +
                '</div>'

            //get .tree element and append the dialog to it
            var tree = document.getElementsByClassName("tree")[0];
            tree.appendChild(dialog);
        }
    </script>
</body>
</html>