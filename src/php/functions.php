<?php
require 'config.php';
$sufixRegex = "/^([a-zA-Z0-9]+([_-]?[a-zA-Z0-9])*){3,64}$/"; 
$errors = array();
$storage_folder = "images";

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