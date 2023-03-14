<?php
    if ($_SERVER['HTTP_HOST'] != 'localhost') {
        $DB_NAME = "";
        $DB_USER = "";
        $DB_PASS = "";  // fill in password here!!
        $DSN     = "pgsql:dbname=$DB_NAME;host=localhost";
    } else {
        $DB_NAME = "";
        $DB_USER = ""; // fill in your local db-username here!!
        $DB_PASS = ""; // fill in password here!!
        $DSN     = "pgsql:dbname=$DB_NAME;host=localhost";
    }
    try {
        $dbh = new PDO($DSN, $DB_USER, $DB_PASS);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,            PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    } catch (Exception $e) {
        die ("Problem connecting to database $DB_NAME as $DB_USER: " . $e->getMessage() );
    }
?>
