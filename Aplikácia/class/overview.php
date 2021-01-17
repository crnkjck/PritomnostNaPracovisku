<?php
require 'day.php';

class Overview {
  var $days = [];
  var $y, $m, $last_d;
  var $user_id = 0;
  var $personal_id = 0;

  // ak posles user_id, ukaze to overview iba pre daneho usera
  function __construct($y, $m, $user_id = 0, $personal_id = 0) {
    $this->user_id = intval( $user_id );
    $this->personal_id = intval( $personal_id );
    $this->y = intval( $y );
    $this->m = intval( $m );
    $this->last_d = date("t", strtotime("$this->y-$this->m-1"));
    $this->get_dates();
  }

  // nacitaj vsetky udalosti
  function get_dates() {
    global $conn, $my_account;

    $user_sql = "";
    if ( $this->user_id > 0 ) $user_sql = "user_id = '$this->user_id' AND";

    $absences = $conn->query("SELECT id, DAY(date_time) as day, user_id,
                              (SELECT u.status FROM users AS u WHERE u.id = user_id) AS user_status FROM absence
                              WHERE $user_sql YEAR(date_time) = '$this->y' AND MONTH(date_time) = '$this->m'
                              HAVING user_status > 0 ORDER BY date_time");

    $holidays = $conn->query("SELECT DAY(date_time) as day, description FROM holidays
                              WHERE MONTH(date_time) = '$this->m' AND YEAR(date_time) = '$this->y' ORDER BY date_time");

    while ( $h = $holidays->fetch_assoc() ) $this->days[ $h["day"] ] = $h["description"];

    while ( $a = $absences->fetch_assoc() ) {
        $day = new Day( $a["day"], $this->m, $this->y, $a["user_id"] );

        if (isset($my_account)) {
          if ( $day->public == 1 || $my_account->user ) {
            if ( !isset( $this->days[ $a["day"] ] ) )
              $this->days[ $a["day"] ] = [];

            if ( is_array($this->days[ $a["day"] ]) )
              array_push( $this->days[ $a["day"] ], $day);
          }
        }
    }

    ksort($this->days);
  }

  function run( $title = 1 ) {
    global $sk_months, $sk_types, $sk_subtypes, $users, $my_account;
    $str = "";

    // zobrazit titulok s posuvacom mesiacov ??
    if ( $title ) {
      // vypis nazvu mesiaca a sipok
      $str .= print_overview_title(
        $this->m, $this->y,
        // stiahnutie vykazu
        ($my_account->secretary && $this->user_id == 0)
          ? print_report_link( $this->m, $this->y )
          : '');
      // vypis mena ak je zapnuty filter
      if ( $this->user_id != 0 )
        $str .= print_overview_filter ( $users[$this->user_id]->name, $users[$this->user_id]->surname );
    }

    $str2 = "";
    // vypis obsahu overview (vsetkych boxov)
    foreach ( $this->days as $day => $absences ) {
      // ak ej to string, tak je to sviatok/volno
      if ( is_string( $absences ) ) {
        $vals =  print_overview_box_value( 0, "", $absences );
        $str2 .= print_overview_box ( $sk_months[ $this->m ], $this->y, $day, "holiday", $vals );
      }
      else{
        $vals = "";

        foreach ( $absences as $a ) {
          // zobraz iba schvalene (okrem mna, sekretarky a schvalovatela)
          if ( $a->confirmation || $my_account->id == $a->user_id ||
               $my_account->secretary || $my_account->request_validator ) {
            $state = "";
            if ( !$a->confirmation ) $state = " <strong>(zatiaľ neschválené)</strong>";

            $vals .=  print_overview_box_value(
              $a->absence_id,
              $this->remove_button( $a, $users[ $a->user_id ]->name, $users[ $a->user_id ]->surname ),
              $users[ $a->user_id ]->name . $state,
              $users[ $a->user_id ]->surname,
              $sk_types[ $a->type ],
              display_time( $a->from_time, $a->to_time ),
              $a->description
            );
          }
        }
        // ak nieje co zobrazit tak nevykresluj box
        if ( $vals ) $str2 .= print_overview_box ( $sk_months[ $this->m ], $this->y, $day, "", $vals );
      }
    }
    if ( !$str2 ) $str2 = print_overview_box ( "", "", "Žiadne záznamy ..", "", "" );
    return $str . $str2;
  }

  // button na odstranenie nepritomnosti priamo z overview
  function remove_button( $a, $name, $surname ) {
    global $my_account;

    if (!isset($my_account) || !isset($a)) return "";
    // button ukaz iba pri mojich udalostiach (alebo sekretarke)
    if ( ( $my_account->id == $a->user_id &&
            edit_date( $a->year, $a->month, $a->type ) ) ||
          $my_account->secretary ) {
      return print_overview_box_value_remove ( $this->y, $this->m, $name, $surname, $a->absence_id, $this->personal_id );
    }
    return "";
  }

  static function get_absences( $year, $month ) {
    global $conn;
    $stm = $conn->prepare("
      SELECT user_id, DAY(date_time) as day, from_time, to_time,
        type, description, public
      FROM absence JOIN users ON user_id = users.id
      WHERE YEAR(date_time) = ?
        AND MONTH(date_time) = ?
        AND users.status >= ?
      ORDER BY user_id, date_time");
    if ( !$stm ) return $conn->$error;
    $regular = User::STATUS_REGULAR; // must be passable by reference
    if ( !$stm || !$stm->bind_param("iii", $year, $month, $regular) )
      return $conn->$error;
    return execute_stm_and_fetch_all( $stm );
  }

  static function get_public_holidays( $year, $month ) {
    global $conn;
    $stm = $conn->prepare("
      SELECT DAY(date_time) as day, description FROM holidays
      WHERE YEAR(date_time) = ?
        AND MONTH(date_time) = ?
      ORDER BY date_time");
    if ( !$stm->bind_param("ii", $year, $month) ) return [];
    return execute_stm_and_fetch_all( $stm );
  }

}

?>
