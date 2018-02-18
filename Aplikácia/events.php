<?php

require 'include/config.php';
require 'class/user.php';

require 'template/main_template.php';
require 'template/events.php';

$my_account = User::login(2);

$year = get_year();
$year_minus = $year - 1;
$year_plus = $year + 1;

echo print_header() . print_events( $year, $year_minus, $year_plus ) . print_footer();

?>
