<?php

require '../include/config.php';
require '../class/user.php';
require '../class/day.php';
require '../template/calendar.php';

// kontrola statusu prihláseného používateľa
$my_account = User::login(User::STATUS_REGULAR);
$personal_id = intval($my_account->personal_id);
$user = $my_account;

if ( post(["personal_id"]) &&
    $my_account->status == User::STATUS_SECRETARY &&
    intval(post("personal_id")) > 0 ) {
  $personal_id = intval( post("personal_id") );
  $user = User::get( $personal_id );
}

$surname_name = escapeshellarg(preg_replace('/[\\^_{}]/', ' ', $user->name . " " . $user->surname));
$year = preg_replace('/[^0-9]/', '', post("year"));
$from_time = preg_replace('/[^0-9[:space:].]/', '', post("from_time"));
$to_time = preg_replace('/[^0-9[:space:].]/', '', post("to_time"));
$num_of_days = preg_replace('/[^0-9]/', '', post("num_of_days"));
$request_date = preg_replace('/[^0-9[:space:].]/', '', post("request_date"));

$jobname = preg_replace('/[^a-zA-Z0-9]/','-',
            preg_replace( '/[.[:space:]]/', '',
            join('-', array($user->username, $year, $from_time, $to_time))));

$command = __DIR__ . "/../tools/dovolenkovy-listok.sh \
        '$printer_host' \
        '$printer' \
        '$jobname' \
        $surname_name \
        '$personal_id' \
        '$department' \
        '$department_id' \
        '$year' \
        '$from_time' \
        '$to_time' \
        '$num_of_days' \
        '$request_date'";
$output = array();
$return_val = 0;

$lastout = exec($command, $output, $return_val);

if ($return_val != 0) {
    header("HTTP/1.0 500 Internal server error");
    echo(join("\n", array_map(htmlspecialchars, $output)));
} else {
    echo(htmlspecialchars($lastout));
}
?>
