<?php

require '../include/config.php';
require '../class/user.php';

// kontrola statusu prihláseného používateľa
$my_account = User::login(2);

// nastav rok ( ak je neplatny nastavi aktualny rok )
$year = get_year();

if ( post(["m1", "m2", "m3", "m4", "m5", "m6", "m7", "m8", "m9", "m10", "m11", "m12"]) ) {
  $months = [ 0, intval(post("m1")), intval(post("m2")), intval(post("m3")), intval(post("m4")), intval(post("m5")), intval(post("m6")),
              intval(post("m7")), intval(post("m8")), intval(post("m9")), intval(post("m10")), intval(post("m11")), intval(post("m12"))
  ];

  $check = true;

  for ( $i = 1; $i <= 12; $i++ ) {
    $sql = $conn->query( "SELECT * FROM deadlines WHERE year = '$year' AND month = '$i'" );
    if ( $sql->fetch_assoc() )
      $sql = $conn->query("UPDATE deadlines SET day = '$months[$i]' WHERE year = '$year' AND month = '$i'");
    else
      $sql = $conn->query("INSERT INTO deadlines (year, month, day) VALUES ('$year', '$i', '$months[$i]')");
    if ( $sql !== TRUE ) $check = false;
  }

  if ( $check )
    echo message("ok", "<b>Uložené</b><br>Zápis termínov bol úspešný.", 1);
  else
    echo message("error", "<b>Chyba</b><br>Pri zápise nastal problém a údaje zrejme neboli uložené (pre kontrolu obnovte stránku)", 1);

}

?>
