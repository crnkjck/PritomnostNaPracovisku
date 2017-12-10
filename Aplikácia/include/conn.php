<?php

$conn = new mysqli("localhost", "root", "", "tis2");
if($conn->connect_error) die("Connection failed... DB - ERROR");
$conn->set_charset("utf8");

?>
