<?php

require '../include/config.php';
require '../class/user.php';
require '../class/day.php';

// kontrola statusu prihláseného používateľa
$my_account = User::login(User::STATUS_REGULAR);

// vytvor pole s informaciam o vsetkych pouzivateloch (potrebne pre vykreslenie prehladu)
$users = User::create_all_users();

if ( post(["absence_id"]) ) {
  $absence_id = intval( post("absence_id") );

  if ( $day = Day::get($absence_id) ) {
    if ( ( $my_account->id == $day->user_id &&
            edit_date( $day->year, $day->month, $day->type ) ) ||
          $my_account->secretary ) {
      if ( $day->remove() ) {
        $my_account = User::login();
        echo "<strong>Odstránené: " . $users[$day->user_id]->surname . " " . $users[$day->user_id]->name . "</strong>";
        echo "<script>$('#holiday_remaining').html('$my_account->holiday_remaining');</script>";
      }
    }
  }
}

?>
