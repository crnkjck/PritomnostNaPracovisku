<?php

require '../include/config.php';
require '../class/user.php';

// kontrola statusu prihláseného používateľa
$my_account = User::login(User::STATUS_SECRETARY);

set_plain_output();
if ( post(["id"]) ) {
  $id = intval( post("id") );
  $sql = $conn->query("DELETE FROM holidays WHERE id = '$id'");
  if ( $sql ) {
    echo "OK";
  }
}


?>
