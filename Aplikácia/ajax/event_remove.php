<?php

require '../include/config.php';
require '../class/user.php';

// kontrola statusu prihláseného používateľa
$my_account = User::login(2);

if ( post(["id"]) ) {
  $id = intval( post("id") );
  $sql = $conn->query("DELETE FROM holidays WHERE id = '$id'");
    set_plain_output();
    echo "OK";
}


?>
