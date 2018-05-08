<?php

function print_header_logged_on ( $name, $surname, $id, $holidays_spend, $holidays_budget ) {
  return "
  <div class='logged_panel'>
    <span class='name'>$name $surname <span>#$id</span></span>
    <span title='Dovolenky'><span class='fa fa-plane'></span> <span id='holiday_spend'>$holidays_spend</span> / $holidays_budget</span>
    <a href='profile.php' title='Môj účet'><span class='fa fa-pencil-square-o'></span></a>
    <a href='?logout' title='Odhlásiť sa'><span class='fa fa-sign-out'></span></a>
  </div>
  ";
}

function print_header_logged_off() {
  return "
  <form class='login_form' method='POST'>
    <span class='lost_pass' onclick='reset_pass(1);'>Zabudnuté heslo?</span>
    <div id='lost_pass_form'>
      Email: <input type='text' id='lost_password' placeholder='Email'>
      <label for='reset_pass' onclick='reset_pass(2);' class='fa fa-sign-in'></label>
      <input id='reset_pass' type='button'>
    </div>
    Prihlasovacie meno: <input name='login_username' type='text' placeholder='Prihlasovacie meno'>
    Heslo: <input name='login_password' type='password' placeholder='Heslo'>
    <label for='login_submit' class='fa fa-sign-in'></label>
    <input id='login_submit' type='submit'>
  </form>
  ";
}

function print_header() {
  global $my_account, $actual_year, $actual_month;

  if ( $my_account->status > 0 ) $str = print_header_logged_on($my_account->name, $my_account->surname, $my_account->personal_id, $my_account->holidays_spend, $my_account->holidays_budget);
  else $str = print_header_logged_off();

  $m2 = "";
  $m3 = "";
  $m4 = "";
  if ( $my_account->status > 0 ) $m2 = "<li><a href='calendar.php'>Prítomnosť na pracovisku</a></li>";
  if ( $my_account->status >= 2 ) $m3 = "
    <li><a href='users.php'>Používatelia</a></li>
    <li><a href='terms.php'>Termíny</a></li>
    <li><a href='events.php'>Udalosti</a></li>
  ";
  if ( $my_account->request_validator ) $m4 = "<li><a href='requests.php'>Žiadosti</a></li>";

  return "
  <!DOCTYPE html>
  <html>
    <head>
      <meta charset='utf-8'>
      <meta name='viewport' content='width=device-width'>
      <meta name='author' content='TEAM UNKNOWNS - TIS 2017/2018'>
      <link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=Ubuntu:400,500,700|Open+Sans:400,700&amp;subset=latin,latin-ext' media='all'>
      <link rel='shortcut icon' href='image/favicon.ico' type='image/x-icon'>
      <link rel='stylesheet' href='style/main.css' type='text/css'>
      <script>
        var user_id = 0;
        var m = $actual_month;
        var y = $actual_year;
      </script>
      <script src='script/jquery2.min.js'></script>
      <script src='script/main.js'></script>
      <title>Dochádzka KAI</title>
    </head>

    <body>
      <header>
        <div class='top'>
          <div class='content'>
            $str
          </div>
        </div>

        <div class='content'>
          <a href='https://fmph.uniba.sk'><img class='logo' src='image/logo_fmfi.png'></a>
          <h1>Univerzita Komenského v Bratislave<br>Fakulta matematiky, fyziky a informatiky<br>Katedra aplikovanej informatiky</h1>
          <h2>Prítomnosť na pracovisku</h2>
        </div>

        <nav>
          <ul>
            <li><a href='index.php'>Prehľad</a></li>
            $m2
            $m3
            $m4
            <div class='spacer'></div>
          </ul>
        </nav>
      </header>
  ";
}

function print_footer() {
  global $conn, $actual_year;
  $conn->close();

  return "
  <footer>
      <div class='content'>
        <div class='copyright'>Copyright © UK $actual_year</div>
        <div class='about'></div>
        <div class='spacer'></div>
      </div>
    </footer>

    </body>
  </html>
  ";

}


?>
