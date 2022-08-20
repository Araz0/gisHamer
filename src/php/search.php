<?php
header('Content-Type: application/json');
require "functions.php";
$searchTerm = $_GET['term'];
$entryResults = searchEntries($searchTerm);
$categoryResults = searchCategories($searchTerm);
echo json_encode(array_merge($entryResults, $categoryResults));
