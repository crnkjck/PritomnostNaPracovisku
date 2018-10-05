<?php

require '../include/config.php';
require '../class/user.php';
require '../class/day.php';
require '../template/calendar.php';

// kontrola statusu prihláseného používateľa
$my_account = User::login(1);
$personal_id = $my_account->id;
$user = $my_account;

if ( get(["personal_id"]) && $my_account->status == 2 && intval(get("personal_id")) > 0 ) {
  $personal_id = intval( get("personal_id") );
  $user = User::get( $personal_id );
}

// nastav rok a mesiac ( ak su neplatne nastavi aktualny rok a masiac )
$year = get_year();
$month = get_month();

// SEKRETARIAT moze pridavat aj za ostatnich
$admin_str = "";
if ( $my_account->status == 2 ) {
  $users = User::create_all_users();

  $admin_str = " Vyberte používateľa (pokiaľ nerobíte vlastný zápis): <select id='users_dropdown' onchange='user_switch($year, $month, this);'>
                <option value='$user->id'>$user->surname $user->name</option>";
  foreach ( $users as $value ) {
    if ( $personal_id != $value->personal_id ) $admin_str .= "<option value='$value->personal_id'>$value->surname $value->name</option>";
  }
  $admin_str .= "</select>";
}

// zisti pocet dni mesiaca a den v tyzdni ktorym mesiac zacina ( 1 = pondelok, 7 = nedela )
$num_of_days = date("t", strtotime("$year-$month-01"));
$first_day = date("N", strtotime("$year-$month-01")) - 1;

// nastav premenne na buduci mesiac a minuly mesiac (pre posuvniks)
list($year_minus, $month_minus) = month_minus($year, $month);
list($year_plus, $month_plus) = month_plus($year, $month);

// nacitanie dni vybraneho mesiaca
$days = [];
for ( $i = 1; $i <= $num_of_days; $i++ )
  $days[$i] = new Day($i, $month, $year, $user->id);

// vykreslenie kalendara
$data = "";
for ( $w = 0; $w <= 5 ; $w++ ) {
  if ( ($w*7)-$first_day >= $num_of_days ) continue;

  $str = "";
  for ( $d = 1; $d <= 7; $d++ ) {
      $day_number = ($w * 7) + $d - $first_day;

      if ( $day_number < 1 || $day_number > $num_of_days )
        $str .= print_calendar_table_td_null();
      else {
        $day = $days[ $day_number ];

        $class = "week";
        if ( $day->day_of_week > 5 )
          $class="weekend";
        if ( $day->holiday )
          $class = "holiday";
        if ( $day->type )
          $class = "absence";

        $str .= print_calendar_table_td( $day_number, $class, $day->confirmation, $day->type );
      }
  }
  $data .= print_calendar_table_tr( $str );
}

// nacitaj dovolenky (pre box na tlacenie dovolenkovych listkov)
$start = $end = $count = 0;
$holidays_data = "";

for ( $i = 1; $i <= $num_of_days; $i++ ) {
  if ( $days[$i]->type == 3 ){
    if ( !$start )
      $start = $i;
    $end = $i;
    $count += holiday_hours_interval($days[$i]->from_time, $days[$i]->to_time);
  }
  if ( $i == $num_of_days || ( $days[$i]->type != 3 && $days[$i]->day_of_week <= 5 && !$days[$i]->holiday ) ){
    if ( $start && $end ) {
      $year = date("Y", strtotime( $days[$start]->date ) );
      $from = sk_format_short_date( $days[$start]->date );
      $to = sk_format_short_date( $days[$end]->date );
      $request_date = sk_format_date( $days[$start]->insert_time );
      if ( strtotime( $days[$start]->insert_time ) > strtotime( $days[$start]->date ) )
        $request_date = "";
      $holidays_data .= print_calendar_holidays_value ( $user, $year, $from, $to, $count, $request_date );
      $start = $end = $count = 0;
    }
  }
}
if ( !$holidays_data ) $holidays_data = print_calendar_holidays_empty();

// GENEROVANIE HTML KODU
if ($user->id == $personal_id) echo print_calendar_holiday_script ( $user->holidays_spend );

echo print_calendar_table($year, $month, $year_minus, $month_minus, $year_plus, $month_plus, $data, $user->personal_id, $admin_str);
echo print_calendar_holidays( $holidays_data );
echo print_calendar_overview($year, $month, $user->id, $user->personal_id);

?>
