<?php
  if ( isset($_GET['y']) and isset($_GET['m']) and isset($_GET['id']) ) {
    $y = intval($_GET['y']);
    $m = intval($_GET['m']);
    $pid = intval($_GET['id']);
  }
  else exit();

  require '../include/config.php';
  require '../include/conn.php';
  require '../class/user.php';
  $my_account = User::check_login();
  $users = User::create_all_users();
  require '../class/overview.php';

  $overview = new Overview($y, $m, $pid);
  echo $overview->run();
?>
