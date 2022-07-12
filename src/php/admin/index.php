<!DOCTYPE html>
<html lang="de">

<?php
$pagetitle = "Admin | Gishamer";
require "../parts/head.php";

if (!userIsLoggedIn()) {
    header("Location: /admin/login.php");
}

?>

<body>
    <?php require "../parts/nav.php"; ?>
    <section class="section-top">
        <h1>Admin Page</h1>
        <div class="section-top__categories">
            <a class="section-top__categories__entry" href="/admin/create_main_category.php">
                <img class="category_icon" src="/media/icon_folder.png" alt="Main Category Icon">
                <p>Hauptkategorie erstellen</p>
            </a>
            <a class="section-top__categories__entry" href="/admin/manage_entry.php">
                <img class="category_icon" src="/media/icon_attachment.png" alt="Main Category Icon">
                <p>Eintrag erstellen</p>
            </a>
            <a class="section-top__categories__entry" href="/admin/news_post.php">
                <img class="category_icon" src="/media/icon_news.png" alt="Main Category Icon">
                <p>Post erstellen</p>
            </a>
            <a class="section-top__categories__entry" href="/admin/create_user.php">
                <img class="category_icon" src="/media/icon_account.png" alt="Main Category Icon">
                <p>Admin Account erstellen</p>
            </a>
        </div>
    </section>
    <section class="admin-news">
        <h2>News</h2>
        <div class="admin-news__mini-news">
            <?php
            $all_news = getAllNews();
            if (count($all_news) > 0) {
                foreach ($all_news as $i => $news_post) {
                    include '../parts/news_post-mini.php';
                }
            }

            ?>
    </section>
</body>

</html>