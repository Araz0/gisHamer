<!DOCTYPE html>
<html lang="de">

<?php
$pagetitle = "News Post | Gishamer";
require "../parts/head.php";

allowAdminOnly();

$news_id = $_GET['nid'] ? $_GET['nid'] : null;
$thumbnail_input = "news_thumbnail";
$_eintrags_thumbnail = "/media/thumbnail_fallback.jpg";
$news_title = "";

$news_message = "";

if (isset($_POST['create_news'])) {
    $news_title = $_POST['news_title'];
    $news_message = $_POST['news_text'];

    $news_thumbnail = uploadToStorage(array('jpeg', 'jpg', 'png'), $storage_folder, array(basename($_FILES[$thumbnail_input]['name']), $_FILES[$thumbnail_input]['tmp_name'], $_FILES[$thumbnail_input]['size'], $_FILES[$thumbnail_input]['type'], $_FILES[$thumbnail_input]['error']));
    if ($news_thumbnail == null || $news_thumbnail == -1) { /*echo implode("\n ",$errors); exit();*/
        $news_thumbnail = $thumbnail_fallback;
    }

    if (empty($errors)) {
        createNews($news_title, $news_thumbnail, $news_message);
        header("Location: /");
    }
}
if (isset($news_id)) {
    $news_post = getNews($news_id);
    if ($news_post->id != $news_id) {
        header("Location: /404.php");
        die();
    }
    $news_title = $news_post->title;
    $_eintrags_thumbnail = $news_post->thumbnail;
    $news_message = $news_post->message;
}
if (isset($_POST['update_news'])) {
    $news_title = $_POST['news_title'];
    $news_message = $_POST['news_text'];

    $news_thumbnail = uploadToStorage(array('jpeg', 'jpg', 'png'), $storage_folder, array(basename($_FILES[$thumbnail_input]['name']), $_FILES[$thumbnail_input]['tmp_name'], $_FILES[$thumbnail_input]['size'], $_FILES[$thumbnail_input]['type'], $_FILES[$thumbnail_input]['error']));
    if ($news_thumbnail == null || $news_thumbnail == -1) {
        $news_thumbnail = $_eintrags_thumbnail;
    }

    if (empty($errors)) {
        updateNews($news_id, $news_title, $news_thumbnail, $news_message);
        header("Location: /");
        die();
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
    <h1>Eintrag <?php echo isset($news_id) ? 'bearbeiten' : 'erstellen'; ?></h1>
    <section>
        <?php include('../parts/popups.php'); ?>
        <form action="" method="post" enctype="multipart/form-data" <?php if (isset($news_id)) { ?>onsubmit="return confirm('Are you sure about this change?');" <?php } ?>>
            <label for="news_title"><b>Titel</b><br>
                <input type="text" id="news_title" name="news_title" placeholder="Titel des Eintrags" value="<?php echo $news_title; ?>" required>
            </label>

            <label for="news_thumbnail"><b>Bild</b><br>
                <img class="form_thumbnail" id="form_thumbnail" src="<?php echo $_eintrags_thumbnail; ?>" alt="News Post Thumbnail Image"><br>
                <input type="file" name="news_thumbnail" id="news_thumbnail" max-size="100000" accept="image/*,.jpg">
            </label>

            <label for="news_text"><b>Text</b><br>
                <textarea id="news_text" name="news_text" rows="10" placeholder="Text des Eintrags" required><?php echo $news_message; ?></textarea>
            </label>

            <?php if (isset($news_id)) { ?>
                <input type="submit" value='Speichern' name='update_news'>
                <input type="submit" value='Löschen' name='delete_news'>
            <?php } else { ?>
                <input type="submit" value='Speichern' name='create_news'>
            <?php } ?>
        </form>
    </section>
    <script>
        const thumbnailInput = document.getElementById('news_thumbnail');
        thumbnailInput.addEventListener('change', () => {
            if (thumbnailInput.files && thumbnailInput.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('form_thumbnail').src = e.target.result;
                }
                reader.readAsDataURL(thumbnailInput.files[0]);
            }
        })
    </script>
</body>
</html>