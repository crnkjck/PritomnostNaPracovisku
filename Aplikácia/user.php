<?php

require 'include/config.php';

require 'class/user.php';

require 'template/main_template.php';
require 'template/user.php';

$my_account = User::login(User::STATUS_SECRETARY);

$id = "";
$personal_id = "";
$name = "";
$surname = "";
$email = "";
$username = "";
$holidays_budget = "";
$status = 1;

if ( get(["personal_id"]) ) {
  $p_id = get("personal_id");
  $user = User::get( $p_id );

  $id = $user->id;
  $personal_id = $user->personal_id;
  $name = $user->name;
  $surname = $user->surname;
  $email = $user->email;
  $username = $user->username;
  $holidays_budget = $user->holidays_budget;
  $status = $user->status;
}

echo print_header() . print_user_add ( $id, $personal_id, $name, $surname, $email, $username, $holidays_budget, $status ) . print_footer();

?>
