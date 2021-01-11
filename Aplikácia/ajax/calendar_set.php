<?php

require '../include/config.php';
require '../class/user.php';
require '../class/day.php';
require '../template/calendar.php';

// kontrola statusu prihláseného používateľa
$my_account = User::login(1);
$personal_id = $my_account->id;
$user = $my_account;

// pridavanie zapisu pre niekoho ineho (ak si sekretar)
if ( post(["personal_id"]) && $my_account->status == 2 && intval(post("personal_id")) > 0 ) {
  $personal_id = intval( post("personal_id") );
  $user = User::get( $personal_id );
}

// nastav rok a mesiac ( ak su neplatne nastavi aktualny rok a masiac )
$year = get_year();
$month = get_month();

// SEKRETARIAT moze pridavat aj za ostatnich
$admin_str = "";
if ( $my_account->status == 2 ) {
  $admin_str = "Pridávate údaje pre používateľa: <b>$user->surname $user->name</b>";
}

// prvý a posledný deň vybraného časového rozmedzia
if ( post(["d1", "d2"]) ) {
  $date1 = intval( post("d1") );
  $date2 = intval( post("d2") );

  if ( $date2 < $date1 && $date2 > 0 ) {
    $date1 = intval( post("d2") );
    $date2 = intval( post("d1") );
  }

  // single ukladá údaj o tom, či je zvolený len jeden deň alebo časové rozmedzie (0 = rozmedzie, 1 = deň)
  if ( checkdate( $month, $date1, $year ) ) {
    if ( $date2 != $date1 && checkdate( $month, $date2, $year ) ) $single = 0;
    else { $single = 1; $date2 = $date1; }
  }
  else exit();
}
else exit();

// načíta všetky voľné dni z časového rozmedzia ( ak niesu dovolenka alebo víkend alebo ani obsadené inou neprítomnosťou )
$days = [];
for ( $i = $date1; $i <= $date2; $i++ ) {
  $day = new Day($i, $month, $year, $user->id);
  if ( $day->type == 0 && $day->day_of_week <= 5 && $day->holiday == "" )
    array_push($days, $day);
}

// ak bol potvrdený formulár tak údaje zapíše do databázy
if ( post(["is_public", "type", "description"]) ) {
  $public = intval( post("is_public") );
  $type = intval( post("type") );
  $description = post("description");
  $from_time = "08:00:00";
  $to_time = "16:00:00";

  if ( post(["time_type", "from_h", "from_m", "to_h", "to_m"]) ) {
    $time_type = intval( post("time_type") );
    if ( $time_type == 2 ) {
      $from_time = intval( post("from_h") ) . ":" . intval( post("from_m") ) . ":00";
      $to_time = intval( post("to_h") ) . ":" . intval( post("to_m") ) . ":00";
    }
  }

  // zistí počet dní dovolenky, ktoré vybrané rozmedzie zaberie
  $holidays_num = 0;
  foreach ( $days as $d ) {
    $holidays_num += holiday_hours_interval( $from_time, $to_time );
  }

  // skontroluje deadline
  if ( !edit_date( $year, $month, $type ) && $my_account->status != 2 ){
    echo message( "error", "<b>Chyba</b><br>Čas pre pridávanie / editovanie zvolenej absencie už vypršal." );
  }
  // ak je to dovolenka, skontroluje či má dostatok volnej dovolenky
  else if ( $type == 3 && $user->get_holiday_allowance($year) === NULL && $month != 1 ) {
    echo message( "error", "<b>Dovolenku nemožno zaevidovať</b><br>
        Pre rok $year ešte táto aplikácia nepozná váš nárok na dovolenku. Môžete žiadať iba o&nbsp;januárovú dovolenku." );
  }
  else if ( $type == 3 && $user->get_holiday_allowance($year) !== NULL &&
            $user->get_holiday_allowance($year) < $user->get_holiday_spent($year) + $holidays_num ) {
    $remaining = $user->get_holiday_allowance($year) - $user->get_holiday_spent($year);
    echo message( "error", "<b>Dovolenku nemožno zaevidovať</b><br>
        Požadovaný počet dovolenkových dní ($holidays_num) prekračuje váš zostatok ($remaining) pre rok $year." );
  }
  // ak je všetko v poriadku zapíš neprítomnosť
  else {
    foreach ( $days as $d ) {
      $result = $d->set( $type, $public, $description, $from_time, $to_time );
      if ( $result ) $d->insert();
    }
    if ( $type == 3 && $user->get_holiday_allowance($year) === NULL ) {
      echo message( "info", "<b>Zapísali ste si dovolenku na rok $year, pre ktorý táto aplikácia ešte nepozná váš nárok na dovolenku.</b><br/>Uistite sa, že ste svoj nárok neprekročili." );
    }
    echo print_calendar_inserted_script ($year, $month, $user->personal_id);
  }
}
// ak nebol vyplnený formulár, tak ho vygenerej
else {
  if ( $single )
    $single = print_calendar_set_form_single();
  else
    $single = "";

  $days_str = "";
  foreach ( $days as $d )
    $days_str .= print_calendar_set_form_days ( sk_format_date($d->date), $sk_days[ $d->day_of_week ] );

  $types_str = "";
  foreach ( $sk_types as $key => $value ) {
    $ch = "";
    if ( $key == 1 ) $ch = "checked";
    $types_str .= print_calendar_set_form_types ( $key, $value, $ch );
  }

  echo print_calendar_set_form ( count($days), $days_str, $single, $year, $month, $date1, $date2, $types_str, $user->personal_id, $admin_str );
}
?>
