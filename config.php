<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('DB_USERNAME', 'mohammad_newsu');
define('DB_PASSWORD', 'wasim!@#$');
define('DB_HOST', 'localhost');
define('DB_NAME', 'mohammad_mostpopularnews');

$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$db) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}


$db->set_charset("utf8");
?>