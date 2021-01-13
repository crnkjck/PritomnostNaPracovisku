<?php

require '../include/config.php';
require '../class/user.php';
require '../template/events.php';

// kontrola statusu prihláseného používateľa
$my_account = User::login(User::STATUS_SECRETARY);

// nastav rok ( ak je neplatny nastavi aktualny rok )
$year = get_year();

$sql = $conn->query("SELECT * FROM holidays WHERE YEAR(date_time) = '$year' ORDER BY MONTH(date_time), DAY(date_time)");

$str = "";
while ( $h = $sql->fetch_assoc() )
  $str .= print_events_table_row( $h["id"], sk_format_date( $h['date_time'] ), $h["description"] );

echo print_events_table( $str ) ;

?>
