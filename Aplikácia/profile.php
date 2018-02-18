<?php

/*
  $b = password_hash("rasmuslerdorf", PASSWORD_BCRYPT);
  if ( password_verify("rasmuslerdorf", $a) ) echo "WIN ($a)";
*/

require "include/config.php";

require "class/user.php";

require 'template/main_template.php';
require "template/profile.php";

$my_account = User::login(1);

echo print_header();

echo print_profile_edit (
    $my_account->name,
    $my_account->surname,
    $my_account->username,
    $my_account->email
);

echo print_footer();

?>
