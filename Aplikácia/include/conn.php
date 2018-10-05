<?php

ini_set("mysqli.default_socket", "/tmp/mysql.sock");
$conn = new mysqli("localhost", "root", "", "tis2");
if($conn->connect_error) die("Connection failed... DB - ERROR");
$conn->set_charset("utf8");

session_start();

?>
