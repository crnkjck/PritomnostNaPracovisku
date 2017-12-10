<?php
  if ( isset($_GET['id']) and isset($_GET['date']) ) {
    $id = intval($_GET['id']);
    $date = $_GET['date'];
    $y = intval( date("Y", strtotime($date)) );
    $m = intval( date("n", strtotime($date)) );
  }
  else exit();

  require '../include/config.php';
  require '../include/conn.php';
  require '../class/user.php';
  $my_account = User::check_login();
  $users = User::create_all_users();

  $status = true;

  if ( !$my_account->super_user and !$my_account->admin ) {
    if ( $id != $my_account->id ) $status = false;
    if ( $actual_year == $y and $actual_month == $m and $actual_day > 20 ) $status = false;
    if ( $actual_year == $y and $actual_month > $m ) $status = false;
    if ( $actual_year > $y ) $status = false;
  }

  if ( $status ) {
    $c = $conn->query("DELETE FROM absence WHERE date_time = '$date' and user_id = '$id'") === TRUE;
    if ( $c ) $str = "Odstránené: " . $users[$id]->get_full_name();
    else $str = "Nastala chyba, údaj nebol odstránený: " . $users[$id]->get_full_name();
    echo "<div class='name'><strong>$str</strong></div><div class='spacer'></div>";
  }
  else {
    "<div class='name'><strong>Nemáte oprávnenie zmazať tento údaj !</strong></div><div class='spacer'></div>";
  }
?>
