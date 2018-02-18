<?php
require 'include/config.php';

require 'class/user.php';

require 'template/main_template.php';
require 'template/calendar.php';

$my_account = User::login(1);

$year = get_year();
$month = get_month();

echo print_header() . print_calendar($year, $month) . print_footer();

?>
