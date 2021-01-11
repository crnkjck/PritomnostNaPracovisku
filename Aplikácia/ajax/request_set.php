<?php

require '../include/config.php';
require '../class/user.php';

// kontrola statusu prihláseného používateľa ( 1,1 = vedúci katedry )
$my_account = User::login(1,1);

if ( post(["id"]) ) {
  $id = intval( post("id") );

  $sql = $conn->query( "SELECT confirmation FROM absence WHERE id = '$id'");
  if ( $r = $sql->fetch_assoc() ){
    $state = intval( ! boolval($r["confirmation"]) );

    $check = $conn->query( "UPDATE absence SET confirmation = '$state' WHERE id = '$id'" ) === TRUE;

    set_plain_output();
    if ( $state && $check )
      echo "OK1";
    else if ( $check )
      echo "OK2";
  }
}

?>
