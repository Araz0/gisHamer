<!DOCTYPE html>
<html lang="de">

<?php 
    $pagetitle = "Home | Gishamer";
    require "./parts/head.php";

    $main_categories = getMainCategories();
?>

<body>
    <?php require "parts/nav.php"; ?>
    <section class="section-top">
        <h1>Gishamer Intranet</h1>
        <div class="section-top__categories">
            <?php 
                if (count($main_categories) > 0) {
                    foreach ($main_categories as $i => $category) {
                ?>
                    <a class="section-top__categories__entry" href="/">
                        <img class="category_icon" src="<?php echo $category->icon; ?>" alt="Main Category Icon">
                        <p><?php echo "$category->title"; ?></p>

                    </a>
                <?php
                    }
                }else {
                ?>
                    <p>Noch keine Hauptkategorien erstellt.</p>
                <?php
                }
                ?>
            </div>
    </section>
    <section class="section-news">
        <h1>News</h1>
    </section>
</body>
</html>