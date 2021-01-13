<?php

require '../include/config.php';
require '../class/user.php';

// kontrola statusu prihláseného používateľa
$my_account = User::login(User::STATUS_REGULAR);

if ( post(["username", "email", "password_new_1", "password_new_2", "password"]) ) {
  $username = post("username");
  $email = post("email");
  $password_new_1 = post("password_new_1");
  $password_new_2 = post("password_new_2");
  $password = post("password");

  if ( $password ) {
    if ( $username && $email ) {
      $my_account->username = $username;
      $my_account->email = $email;

      if ( $my_account->update( $password ) )
        echo message("ok", "<b>Profil aktualizovaný</b><br>Údaje boli zmenené.", 1);
      else
        echo message("error", "<b>Chyba</b><br>Nesprávne prihlasovacie heslo.", 1);

      if ( $password_new_1 && $password_new_2 ) {
        if ( $password_new_1 == $password_new_2 ) {
          if ( $my_account->update_password( $password, $password_new_1 ) )
            echo message("ok", "<b>Heslo aktualizované</b><br>Prihlasovacie heslo bolo zmenené.", 1);
          else
            echo message("error", "<b>Chyba</b><br>Nesprávne prihlasovacie heslo.", 1);
        }
        else
          echo message("error", "<b>Chyba</b><br>Nové heslo musí byť zhodné v oboch riadkoch.", 1);
      }

    }
    else
      echo message("error", "<b>Chyba</b><br>Používateľské meno a email musia byť vyplnené.", 1);
  }
  else
    echo message("error", "<b>Chyba</b><br>Pre zmenu údajov musíte zadať heslo.", 1);
}

?>
