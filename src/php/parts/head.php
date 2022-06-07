<?php 
    session_start();
    $root = str_replace($_SERVER['SCRIPT_NAME'],'',$_SERVER['SCRIPT_FILENAME']);
    require "$root/functions.php";
    checkIfInitStartup();
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="/style.css">
    <link rel="shortcut icon" type="image/x-icon" sizes="16x16" href="../../media/favicon.ico">
    <title>Gishamer Intranet</title>
</head>