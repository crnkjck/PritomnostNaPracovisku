<?php

require 'include/config.php';
require 'class/user.php';

require 'template/main_template.php';
require 'template/users.php';

$my_account = User::login(2);

$status = 1;
if ( get(["deactivated"]) ) $status = 0;
$users = User::create_all_users( $status );

$hidden = "hidden";
if ( $status ) $hidden = "";

$char = "";
$data = "";
foreach ( $users as $u ) {
    if ( !$char || $char != first_char($u->surname) ) {
      $char = first_char($u->surname);
      $data .= print_users_char( $char );
    }
    $data .= print_users_person( $u->id, $u->name, $u->surname, $u->personal_id, $hidden, $u->holidays_budget, $u->holidays_spend );
}

echo print_header() . print_users( $data, $status, intval(!$status) ) . print_footer();
?>
