<?php

require '../include/config.php';
require '../class/user.php';

// kontrola statusu prihláseného používateľa
$my_account = User::login(User::STATUS_SECRETARY);

// osobne cislo pouzivatela ktoreho editujeme
if ( get(["personal_id"]) ) $p_id = intval( get("personal_id") );
// ak nieje nastavene tak pridavame noveho pouzivatela
else $p_id = 0;

if ( post(["holidays_budget", "personal_id", "name", "surname", "email", "username", "password", "status"]) ) {
  $user = User::get( $p_id );

  $user->holidays_budget = intval( post("holidays_budget") );
  $user->personal_id = intval( post("personal_id") );
  $user->name = post("name");
  $user->surname = post("surname");
  $user->email = post("email");
  $user->username = post("username");
  $user->status = intval( post("status") );
  $password = post("password");
  
  if ( $user->id == 0 ) {
    if ( $user->insert( $password ) )
      echo message("ok", "<b>Používateľ bol pridaný</b><br>Používateľ $user->name $user->surname bol úspešne pridaný do systému.", 1);
    else
      echo message("error", "<b>Chyba</b><br>Zadali ste neplatné hodnoty. Všetky údaje musia byť vyplnené.", 1);
  }
  else {
    if ( $user->admin_update( $password ) )
      echo message("ok", "<b>Zmeny boli uložené</b><br>Údaje používateľa $user->name $user->surname boli úspešne zmenené.", 1);
    else
      echo message("error", "<b>Chyba</b><br>Zadali ste neplatné hodnoty. Všetky údaje okrem 'Prihlasovacie heslo' musia byť vyplnené.", 1);
  }
}

?>
