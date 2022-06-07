<!DOCTYPE html>
<html lang="de">

<?php 
    $pagetitle = "News Post | Gishamer";
    require "../parts/head.php";
    
    allowAdminOnly();

    $news_title = "";
    $_eintrags_thumbnail = "/media/news_thumbnail.jpg";
    $news_message = "";

    if (isset($_POST['create_news'])) {
        $news_title = $_POST['news_title'];
        $_inputName = "news_thumbnail";
        $input_array = array(basename($_FILES[$_inputName]['name']), $_FILES[$_inputName]['tmp_name'], $_FILES[$_inputName]['size'], $_FILES[$_inputName]['type'], $_FILES[$_inputName]['error']);
        $news_message = $_POST['news_text'];

        if (empty($errors)) {
            echo $news_title;
            echo $_eintrags_thumbnail;
            echo $news_message;
            createNews($news_title, $_eintrags_thumbnail, $news_message);
            //header("Location: /");
        }
    }
    $news_id = $_GET['nid'];
    if (isset($news_id)) {
        $news_post = getNews($news_id);
        if ($news_post->id != $news_id){
            header("Location: /404.php");
            die();
        }
        $news_title = $news_post->title;
        $_eintrags_thumbnail = $news_post->thumbnail;
        $news_message = $news_post->message;

        
    }
    if (isset($_POST['update_news'])) {
        $news_title = $_POST['news_title'];
        $news_thumbnail = $_eintrags_thumbnail;
        $news_message = $_POST['news_text'];
        
        if (empty($errors)) {
            updateNews($news_id, $news_title, $news_thumbnail, $news_message);
        }
    }
    if (isset($_POST['delete_news'])) {
        if (empty($errors)) {
            deleteNews($news_id);
            header("Location: /");
            die();
        }
    }
?>

<body>
    <?php require "../parts/nav.php"; ?>
    <h1>Eintrag <?php echo isset($news_id) ? 'bearbeiten' : 'erstellen';?></h1>
    <section>
        <?php include('../parts/popups.php'); ?>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="news_title"><b>Title</b><br>
                <input type="text" id="news_title" name="news_title" placeholder="Title des Eintrags" value="<?php echo $news_title; ?>" required>
            </label>

            <label for="news_thumbnail"><b>Thumbnail</b><br>
                <img class="form_thumbnail" src="<?php echo $_eintrags_thumbnail; ?>" alt="News Post Thumbnail Image"><br>
                <input type="file" name="news_thumbnail" id="news_thumbnail" max-size="100000" accept="image/*,.jpg">
            </label>
            
            <label for="news_text"><b>Text</b><br>
                <textarea id="news_text" name="news_text" rows="10" placeholder="Text des Eintrags" required><?php echo $news_message; ?></textarea>
            </label>
            
            <?php if (isset($news_id)) { ?>
                <input type="submit" value='Speichern' name='update_news'>
                <input type="submit" value='Löschen' name='delete_news'>
            <?php }else{ ?>
                <input type="submit" value='Speichern' name='create_news'>
            <?php } ?>
        </form>
    </section>
</body>
</html>