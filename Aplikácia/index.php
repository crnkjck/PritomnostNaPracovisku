<?php

require 'include/config.php';

require 'class/user.php';
require 'class/overview.php';

require 'template/main_template.php';
require 'template/index.php';
require "template/overview.php";

$my_account = User::login();
$users = User::create_all_users();

$persons = "";

foreach ( $users as $u ) {
  if ( $u->user ) {
    $p_id = "";
    if ( $my_account->privileged ) $p_id = "#" . $u->personal_id;
    $persons .= print_index_person ( $u->id, $u->name, $u->surname, $p_id );
  }
}

echo print_header() . print_index( $persons, $actual_year, $actual_month) . print_footer();

?>
