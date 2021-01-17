<?php

require '../include/config.php';
require '../include/db_utils.php';
require '../class/user.php';
require '../class/overview.php';

// kontrola statusu prihláseného používateľa
$my_account = User::login(User::STATUS_SECRETARY);

// nastav rok a mesiac ( ak su neplatne nastavi aktualny rok a mesiac )
$year = get_year();
$month = get_month();

$sheet_data = [
  "year" => $year,
  "month" => $month,
  "month_sk" => $sk_months[$month],
  "personal_id_prefix" => $personal_id_prefix,
  "employees" => User::get_users(),
  "public_holidays" => Overview::get_public_holidays($year, $month),
  "absences" => Overview::get_absences($year, $month)
];

// vykresli nahlad
echo json_encode($sheet_data);

?>
