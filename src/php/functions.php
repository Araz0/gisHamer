<?php
require 'config.php';
$sufixRegex = "/^([a-zA-Z0-9]+([_-]?[a-zA-Z0-9])*){3,64}$/";
$usernameRegex = "/^([a-z0-9A-Z.-_]*)$/";
$errors = array();
$storage_folder = "images";

$sec_questions = array(
    "What city were you born in?",
    "What is your oldest sibling's middle name?",
    "What was the first concert you attended?",
    "What was the make and model of your first car?",
    "In what city or town did your parents meet?"
);

function userIsLoggedIn(){
    return isset($_SESSION['USER']);
}
function allowAdminOnly(){
    if(!userIsLoggedIn()){
        header("Location: /login.php");
    }
}
function allowAdminOnlyOrInitPhase(){
    if(!userIsLoggedIn() && dbHasUsers()){
        header("Location: /login.php");
    }
}

function checkIfInitStartup(){
    //check if no users in db, then redirect to create user page
    global $dbh;
    $query = "SELECT * FROM users";
    $sth = $dbh->prepare($query);
    $sth->execute();
    $users = $sth->fetchAll();
    if (count((array)$users) < 1){ 
        if (basename($_SERVER['PHP_SELF']) != "create_user.php") {
            header('Location: /admin/create_user.php');
            exit;
        }
    }
}
function dbHasUsers(){
    //check if no users in db
    global $dbh;
    $query = "SELECT * FROM users";
    $sth = $dbh->prepare($query);
    $sth->execute();
    $users = $sth->fetchAll();
    if (count((array)$users) < 1){ 
        return false;
    }else {
        return true;
    }
}

function makeStrUrlReady($string){
    $change_letters_from = ['ä','ö','ü',' '];
    $change_letters_to = ['ea','eo','eu','_'];
    $string = str_replace($change_letters_from, $change_letters_to, $string);
    return preg_replace("/[^a-zA-Z0-9_]/", "", $string);
}

function fileUpload($_inputArray, $_uploadFolder, $_allowedExtentions){
    $errors = [];
    if (isset($_inputArray)) {

        $filename = $_inputArray[0];
        $fileTmpName  = $_inputArray[1];
        $fileSize = $_inputArray[2];
        $fileType = $_inputArray[3];
        $fileError = $_inputArray[4];
        $fileExtension =strtolower(substr($filename, -3));
        $localFileName = "A".md5($filename.$fileTmpName).".$fileExtension";
        
        if (!in_array($fileExtension, $_allowedExtentions)) {
            array_push($errors, "file format must be one of the following: ".implode(" ",$_allowedExtentions));
        }

        if ($fileSize > 10000000) {
            array_push($errors,"File exceeds maximum size (10MB)");
        }
        $uploadFilePath = $_SERVER["DOCUMENT_ROOT"]."/$_uploadFolder/" . $localFileName;

        if (empty($errors)) {
            if (move_uploaded_file($fileTmpName, $uploadFilePath)) {
                //echo $filename." 🚀🚀🚀🚀🚀 \n";
                $localFilePath = "/$_uploadFolder/$localFileName";
                
                return $localFilePath;
            } else {
                echo $filename . "❌❌❌❌❌ \n";
            }
        } else {
            return null;
        }
    }else{
        return null;
    }
}

function createMainCategory($main_category_name, $main_category_icon) {
    global $dbh;
    $query = "INSERT INTO categories (title, icon, type) VALUES (:title, :icon, :type)";
    $sth = $dbh->prepare($query);
    $sth->bindParam('title', $main_category_name, PDO::PARAM_STR);
    $sth->bindParam('icon', $main_category_icon, PDO::PARAM_STR);
    $sth->bindParam('type', 'maincategory', PDO::PARAM_STR);
    $sth->execute();
}

function createSubCategory($category_name, $parent_category_id) {
    global $dbh;
    $query = "INSERT INTO categories (title, icon, type, category_id) VALUES (:title, :icon, :type, :category_id)";
    $sth = $dbh->prepare($query);
    $sth->bindParam('title', $category_name, PDO::PARAM_STR);
    $sth->bindParam('icon', '', PDO::PARAM_STR);
    $sth->bindParam('type', 'subcategory', PDO::PARAM_STR);
    $sth->bindParam('category_id', $parent_category_id, PDO::PARAM_INT);
    $sth->execute();
}

function createtUser($username, $password, $sec_question, $sec_answer){
    global $dbh;
    $username = strip_tags($username);
    $password = password_hash($password, PASSWORD_BCRYPT); //encrypt the password before saving in the database
    // ^ on login, check via password_verify($login_form_pass, db_pass);
    $sec_question = strip_tags($sec_question);
    $sec_answer = strip_tags($sec_answer);
    $email = filter_var(strtolower($email), FILTER_VALIDATE_EMAIL);
    $query = "INSERT INTO users (username, password, sec_question, sec_answer) VALUES (:username, :password, :sec_question, :sec_answer)";
    $sth = $dbh->prepare($query);
    $sth->bindParam('username', $username, PDO::PARAM_STR);
    $sth->bindParam('password', $password, PDO::PARAM_STR);
    $sth->bindParam('sec_question', $sec_question, PDO::PARAM_STR);
    $sth->bindParam('sec_answer', $sec_answer, PDO::PARAM_STR);
    $sth->execute();
}
function getUser($username){
    global $dbh;
    $username = strtolower($username);
    $query = "SELECT * FROM users WHERE username=?";
    $sth = $dbh->prepare($query);
    $sth->execute(array($username));
    return $sth->fetch();
}
function updateUserSecurity($user_id, $password, $sec_question, $sec_answer){
    global $dbh;
    $password = password_hash($password, PASSWORD_BCRYPT); //encrypt the password before saving in the database
    // ^ on login, check via password_verify($login_form_pass, db_pass);

    $query = "UPDATE users SET password=:password, sec_question=:sec_question, sec_answer=:sec_answer WHERE id=:id";
    $sth = $dbh->prepare($query);
    $sth->bindParam('password', $password, PDO::PARAM_STR);
    $sth->bindParam('sec_question', $sec_question, PDO::PARAM_STR);
    $sth->bindParam('sec_answer', $sec_answer, PDO::PARAM_STR);
    $sth->bindParam('id', $user_id, PDO::PARAM_INT);
    $sth->execute();
}

function createNews($title, $thumbnail, $message){
    global $dbh;
    $title = strip_tags($title);
    $message = strip_tags($message);

    $query = "INSERT INTO news (title, message, thumbnail) VALUES (:title, :message, :thumbnail)";
    $sth = $dbh->prepare($query);
    $sth->bindParam('title', $title, PDO::PARAM_STR);
    $sth->bindParam('thumbnail', $thumbnail, PDO::PARAM_STR);
    $sth->bindParam('message', $message, PDO::PARAM_STR);
    $sth->execute();
}
function getNews($news_id){
    global $dbh;
    $query = "SELECT * FROM news WHERE id=?";
    $sth = $dbh->prepare($query);
    $sth->execute(array($news_id));
    return $sth->fetch();
}
function updateNews($news_id, $title, $thumbnail, $message){
    global $dbh;
    $title = strip_tags($title);
    $message = strip_tags($message);
    $dateNow = date('Y-m-d H:i:s');

    $query = "UPDATE news SET title=:title, message=:message, thumbnail=:thumbnail, edit_date=:edit_date WHERE id=:news_id";
    $sth = $dbh->prepare($query);
    $sth->bindParam('title', $title, PDO::PARAM_STR);
    $sth->bindParam('thumbnail', $thumbnail, PDO::PARAM_STR);
    $sth->bindParam('message', $message, PDO::PARAM_STR);
    $sth->bindParam('edit_date', $dateNow, PDO::PARAM_STR);
    $sth->bindParam('news_id', $news_id, PDO::PARAM_INT);
    $sth->execute();
}
function deleteNews($news_id){
    global $dbh;
    $query = "DELETE FROM news WHERE id=:news_id";
    $sth = $dbh->prepare($query);
    $sth->bindParam('news_id', $news_id, PDO::PARAM_INT);
    $sth->execute();
}