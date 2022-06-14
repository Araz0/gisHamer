<!DOCTYPE html>
<html lang="de">

<?php 
    $pagetitle = "Home | Gishamer";
    require "./parts/head.php";
?>

<body>
    <?php require "parts/nav.php"; ?>
    <section class="section-categories">
        <h1>Gishamer Intranet</h1>
    </section>
    <section class="section-news">
        <h1>News</h1>
        <div class="section-news__container">
        <?php 
            $all_news = getAllNews();
            if (count($all_news) > 0) {
                foreach ($all_news as $i => $news_post) {
                    include 'parts/news_post.php';
                }
            }
        ?>
        </div>
    </section>
</body>
</html>