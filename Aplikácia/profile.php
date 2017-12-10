<?php
  require 'include/config.php';
  require 'include/conn.php';
  require 'class/user.php';
  $my_account = User::check_login();
  require 'include/header.php';

/*
  $b = password_hash("rasmuslerdorf", PASSWORD_BCRYPT);
  $a = password_hash("rasmuslerdorf", PASSWORD_BCRYPT);

  if ( password_verify("rasmuslerdorf", $a) ) echo "WIN ($a)";
  if ( password_verify("rasmuslerdorf", $b) ) echo "<br>WIN ($b)<br>";
*/
?>

<div class='content profile'>
  <div class='name'>
    Môj profil: <?php echo $my_account->get_full_name(); ?>
  </div>

  <div>
    <span>Titul</span>
    <input id='p_title' type='text' placeholder='Zadajte titul' value='<?php echo $my_account->title; ?>'>
  </div>

  <div>
    <span>Prihlasovacie meno</span>
    <input id='p_username' type='text' placeholder='Zadajte prihlasovacie meno' value='<?php echo $my_account->username; ?>'>
  </div>

  <div>
    <span>Email</span>
    <input id='p_email' type='text' placeholder='Zadajte email' value='<?php echo $my_account->email; ?>'>
  </div>

  <div>
    <span>Prihlasovacie heslo</span>
    <input id='p_password_new_1' type='password' placeholder='Zadajte nové heslo'><br>
    <input id='p_password_new_2' type='password' placeholder='Znova zadajte nové heslo'>
  </div>

  <div>
    <span>Potvrdenie údajov</span>
    <input id='p_password' type='password' placeholder='Vaše heslo'> <input type='button' value='Potvrdiť'>
  </div>
</div>

<?php
  require 'include/footer.php';
?>
