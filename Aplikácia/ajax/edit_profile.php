<?php
  if (
    isset($_POST[])

  else exit();

  require '../include/config.php';
  require '../include/conn.php';
  require '../class/user.php';
  $my_account = User::check_login();

?>
