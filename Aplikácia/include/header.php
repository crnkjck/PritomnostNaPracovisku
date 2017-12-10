<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width'>
    <meta name='author' content='TEAM UNKNOWNS - TIS 2017/2018'>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu:400,500,700|Open+Sans:400,700&amp;subset=latin,latin-ext" media="all">
    <link rel='shortcut icon' href='image/favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' href='style/main.css' type='text/css'>
    <script>
      var user_id = 0;
      var m = <?php echo $actual_month; ?>;
      var y = <?php echo $actual_year; ?>;
    </script>
    <script src='script/jquery2.min.js'></script>
    <script src='script/main.js'></script>
    <title>Dochádzka FMFI</title>
  </head>

  <body>
    <header>
      <div class='content'>
        <a href='https://fmph.uniba.sk'><img class='logo' src='image/logo_fmfi.png'></a>
        <h1>Fakulta matematiky, fyziky<br> a informatiky</h1>
        <h2>Prítomnosť na pracovisku</h2>
        <?php
          if( $my_account->user ) { echo "
            <div class='logged_panel'>
              <span class='name'>" . $my_account->get_full_name() . " <span>#$my_account->personal_id</span></span>
              <a href='profile.php' title='Môj účet'><span class='fa fa-pencil-square-o'></span></a>
              <a href='?logout' title='Odhlásiť sa'><span class='fa fa-sign-out'></span></a>
            </div>
            ";
          }
          else { echo "
            <form class='login_form' method='POST'>
              <input name='login_username' type='text' placeholder='Prihlasovacie meno'>
              <input name='login_password' type='password' placeholder='Heslo'>
              <label for='login_submit' class='fa fa-sign-in'></label>
              <input id='login_submit' type='submit'>
            </form>
            ";
          }
        ?>
      </div>
    </header>

    <nav>
      <div class='content'>
        <ul>
          <li><a href='index.php'>Prehľad</a></li>
          <li><a href='calendar.php'>Prítomnosť na pracovisku</a></li>
          <div class='spacer'></div>
        </ul>
      </div>
    </nav>
