<?php
$mysqli = new mysqli("localhost", "mohammad_newsu", "wasim!@#$", "mohammad_mostpopularnews");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$mysqli->set_charset("utf8");


$mysqli->close();
?>