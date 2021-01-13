<?php

require 'include/config.php';
require 'class/user.php';

require 'template/main_template.php';
require 'template/requests.php';

// kontrola statusu prihláseného používateľa
// (prihlásený používateľ v zozname potvrdzovačov žiadostí,
// typicky vedúci katedry )
$my_account = User::login(User::STATUS_REGULAR, true);
$users = User::create_all_users();


$year = get_year();
$year_minus = $year - 1;
$year_plus = $year + 1;

$sql = $conn->query("SELECT id, user_id, date_time, from_time, to_time, description, type, confirmation,
                    (SELECT u.status FROM users AS u WHERE u.id = user_id) AS user_status
                    FROM absence WHERE (type = '".ABSENCE_TRAVEL."' OR type = '".ABSENCE_WORKFROMHOME."') AND YEAR(date_time) = '$year'
                    HAVING user_status > 0 ORDER BY confirmation asc, date_time desc");

$str = "";
while ( $r = $sql->fetch_assoc() ) {
  $user_name = $users[ $r["user_id"] ]->name . " " . $users[ $r["user_id"] ]->surname;
  $time = display_time( $r["from_time"], $r["to_time"] );

  $str .= print_requests_table_row ( $r["id"], sk_format_date( $r['date_time'] ), $time, $user_name, $sk_types[$r["type"]], $r["description"], $r["confirmation"] );
}
if ( !$str )
  $str = print_terms_table_row_empty();


echo print_header() . print_requests( $year, $year_minus, $year_plus, $str ) . print_footer();

?>
