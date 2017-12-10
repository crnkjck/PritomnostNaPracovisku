<?php
  require 'include/config.php';
  require 'include/conn.php';
  require 'class/user.php';
  $my_account = User::check_login();
  $users = User::create_all_users();

  require 'include/header.php';
?>

<div class='content'>

  <div class='spacer'></div>

</div>

<?php
  require 'include/footer.php';
?>
