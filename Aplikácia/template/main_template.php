<?php

function print_header_logged_on ( $name, $surname, $id, $holiday_remaining, $holiday_allowance ) {
  return "
  <div class='logged_panel'>
    <span class='name'>$name $surname <span class='personal_id'>#$id</span></span>
    <span>Zostatok dovolenky: <span id='holiday_remaining'>$holiday_remaining</span> / $holiday_allowance</span>
    <a href='profile.php' title='Môj účet'><span class='fa fa-pencil-square-o'></span></a>
    <a href='?logout' title='Odhlásiť sa'><span class='fa fa-sign-out'></span></a>
  </div>
  ";
}

function print_header_logged_off() {
  return "
  <form class='login_form' method='POST'>
    <span class='lost_pass' onclick='resetpass(1);'>Zabudnuté heslo?</span>
    <div id='lost_pass_form'>
      Email: <input type='text' id='lost_password' placeholder='Email'>
      <label for='reset_pass' onclick='resetpass(2);' class='fa fa-sign-in'></label>
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

  if ( $my_account->status > 0 ) $str = print_header_logged_on($my_account->name, $my_account->surname, $my_account->personal_id, $my_account->holiday_remaining, $my_account->holidays_budget);
  else $str = print_header_logged_off();

  $menu_items = array( 'index.php' => "Prehľad" );
  if ( $my_account->status > 0 ) {
    $menu_items['calendar.php'] = 'Vaša neprítomnosť';
  }
  if ( $my_account->status >= 2 ) {
    $menu_items['users.php'] = 'Používatelia';
    $menu_items['terms.php'] = 'Termíny';
    $menu_items['events.php'] = 'Voľné dni';
  }
  if ( $my_account->request_validator ) {
    $menu_items['requests.php'] = 'Žiadosti';
  }
  $menu = join("\n",
    array_map( function($href, $label) {
      return "<li" .
        ($href == basename($_SERVER['PHP_SELF']) ? " class='active'" : "") .
        "><a href='$href'>$label</a></li>";
    }, array_keys($menu_items), $menu_items));

  return "
  <!DOCTYPE html>
  <html>
    <head>
      <meta charset='utf-8'>
      <meta name='viewport' content='width=device-width'>
      <meta name='author' content='TEAM UNKNOWNS - TIS 2017/2018'>
      <link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=Ubuntu:400,400i,700,700i|Open+Sans:400,700&amp;subset=latin,latin-ext' media='all'>
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
          <h1><a href='/'>Prítomnosť na pracovisku</a></h1>
          <h2><a href='//dai.fmph.uniba.sk'>Katedra aplikovanej informatiky</a></h2>
        </div>

        <nav>
          <ul>
            $menu
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
