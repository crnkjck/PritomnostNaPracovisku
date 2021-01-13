<?php

require 'include/config.php';
require 'class/user.php';

require 'template/main_template.php';
require 'template/terms.php';

$my_account = User::login(User::STATUS_SECRETARY);
$users = User::create_all_users();


$year = get_year();
$year_minus = $year - 1;
$year_plus = $year + 1;

$deadlines = [];
$sql = $conn->query("SELECT * FROM deadlines WHERE year = '$year'");
while ( $d = $sql->fetch_assoc() )
  $deadlines[$d["month"]] = $d["day"];

$str = "";
for ( $i = 1; $i <= 12; $i++ ) {
  $value = 20;
  if ( isset( $deadlines[$i] ) )
    $value = $deadlines[$i];
  $month_name = $sk_months[$i];

  $str .= print_terms_table_row( $i, $month_name, $value );
}

echo print_header() . print_terms( $year, $year_minus, $year_plus, $str ) . print_footer();

?>
