<?php

require '../include/config.php';
require '../class/user.php';

// kontrola statusu prihláseného používateľa
$my_account = User::login(User::STATUS_SECRETARY);

// nastav rok ( ak je neplatny nastavi aktualny rok )
$year = get_year();


if ( post(["description", "day", "month"]) ){
  $description = post("description");
  $day = intval( post("day") );
  $month = intval( post("month") );
  $date = "$year-$month-$day";

  if ( $description && checkdate($month, $day, $year) ) {
    $sql = $conn->query("SELECT id FROM holidays WHERE date_time = '$date'");
    if ( ! $sql->fetch_assoc() ) {
      $conn->query("DELETE FROM absence WHERE date_time = '$date'");

      $sql = $conn->prepare("INSERT INTO holidays (description, date_time) VALUES (?, '$date')");
      $sql->bind_param('s', $description);
      if ( $sql->execute() )
        echo message("ok", "<b>Udalosť pridaná</b><br>Udalosť pre deň $day.$month.$year bola úspešne pridaná.", 1);
      else
        echo message("error", "<b>Chyba</b><br>Zápis nebol úspešný.", 1);
    }
    else
      echo message("error", "<b>Chyba</b><br>Pre tento deň už existuje udalosť.", 1);
  }
  else
    echo message("error", "<b>Chyba</b><br>Zadali ste neplatné hodnoty. Skontrolujte dátum a popis.", 1);
}

?>
