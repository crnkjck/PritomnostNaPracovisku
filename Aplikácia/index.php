<?php
  require 'include/config.php';
  require 'include/conn.php';
  require 'class/user.php';
  $my_account = User::check_login();
  $users = User::create_all_users();
  require 'class/overview.php';
  require 'include/header.php';
?>

<div class='content overview'>

  <div class='users_table'>
    <div class='title'>Prehľad vyučujúcich</div>
    <?php
      foreach ( $users as $u ) {
        if ( $u->status > 0 ) {
          $p_id = ""; if ( $my_account->super_user or $my_account->admin ) $p_id = " <span>#" . $u->personal_id . "</span>";
          echo "<div class='person person$u->id' onclick='slide_overview(0, $u->id);'>" . $u->get_full_name(1) . "$p_id</div>";
        }
      }
    ?>
  </div>

  <div id='overview_table'>
    <?php
      $overview = new Overview($actual_year, $actual_month);
      echo $overview->run();
    ?>
  </div>

  <div class='spacer'></div>
</div>

<?php
  require 'include/footer.php';
?>
