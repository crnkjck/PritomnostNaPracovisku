<?php

class Overview {
  var $days = [];
  var $y, $m, $last_d;
  var $user_id = 0;

  function __construct($y, $m, $user_id = 0) {
    $this->user_id = $user_id;
    $this->y = $y;
    $this->m = $m;
    $this->last_d = date("t", strtotime("$y-$m-1"));;

    $this->get_dates();
  }

  function get_dates() {
    global $conn;

    $user_sql = "";
    if ( $this->user_id > 0 ) $user_sql = "user_id = '$this->user_id' AND";

    $dates = $conn->query("SELECT * FROM absence WHERE $user_sql public > 0 AND date_time >= '$this->y-$this->m-1' AND date_time <= '$this->y-$this->m-$this->last_d' ORDER BY date_time");
    $holidays = $conn->query("SELECT * FROM holidays WHERE date_time >= '$this->y-$this->m-1' AND date_time <= '$this->y-$this->m-$this->last_d' ORDER BY date_time");

    while ( $d = $dates->fetch_assoc() ) {
        $x = intval( date("j", strtotime($d["date_time"])) );
        if ( !isset( $this->days[$x] ) ) $this->days[$x] = [];
        array_push( $this->days[$x],
          [ "user_id" => $d['user_id'], "from" => $d['from_time'], "to" => $d['to_time'], "desc" => $d['description'], "type" => $d['type'] ]
        );
    }

    while ( $d = $holidays->fetch_assoc() ) {
        $x = intval( date("j", strtotime($d["date_time"])) );
        $this->days[$x] = [
          [ "user_id" => 0, "from" => null, "to" => null, "desc" => $d['description'], "type" => 0 ]
        ];
    }

    ksort($this->days);
  }

  function run() {
    global $sk_months;
    global $sk_types;
    global $users;

    $str = "<div class='title'>
      <span class='fa fa-chevron-left' onclick='slide_overview(-1);'></span>
      " . $sk_months[ $this->m ] . " $this->y
      <span class='fa fa-chevron-right' onclick='slide_overview(1);'></span>
    </div>" . $this->overview_name();

    foreach ( $this->days as $d => $values ) {
      $str .= "<div class='box box$this->y-$this->m-$d'>
        <div class='title " . $this->is_holiday( $values[0]["user_id"] ) . "'>$d. " . $sk_months[ $this->m ] . " $this->y</div>
        <table><tbody>";

      foreach ( $values as $v ) {
        $str .= "
          <tr class='value value$v[user_id]'>
            <td class='name'>" . $this->display_name( $v["user_id"], $d, $v["desc"] ). "</td>
            <td class='type' rowspan='2'>" . $sk_types[ $v["type"] ] . "</td>
            <td class='time' rowspan='2'>" . $this->display_time( $v["from"], $v["to"] ) . "</td>
          </tr>
          <tr class='desc'><td>$v[desc]</td></tr>";
        }
      $str .= "</tbody></table></div>";
    }

    return $str;
  }

  function is_holiday( $value ) {
    if ( isset( $value ) and $value == 0  ) return "holiday";
    return "";
  }

  function display_time( $from, $to ) {
    if ( !$from or !$to ) return "";
    $t1 = date( "H:i", strtotime($from) );
    $t2 = date( "H:i", strtotime($to) );
    if ( $t1 != "08:00" and $t2 != "16:00" ) return "<strong>$t1 - $t2</strong>";
    return "Celý deň";
  }

  function overview_name() {
    global $users;

    if ( $this->user_id != 0 ) {
      return "<div class='filter'>
        <strong>Filter:</strong>
        " . $users[$this->user_id]->get_full_name() . "
        <span class='fa fa-times' onclick='slide_overview(0,-1);'></span>
      </div>";
    }
    return "";
  }

  function display_name( $u_id, $d ) {
    if ( !$u_id ) return "";

    global $my_account;
    global $actual_year;
    global $actual_month;
    global $actual_day;
    global $users;

    $str = "<span onclick='remove_record($u_id, \"$this->y-$this->m-$d\", \"" . $users[$u_id]->get_full_name() . "\");' class='fa fa-times admin_icon'></span>";

    if ( $my_account->super_user or $my_account->admin ) return $str . $users[ $u_id ]->get_full_name();
    if ( $u_id != $my_account->id ) $str = "";
    if ( $actual_year == $this->y and $actual_month == $this->m and $actual_day > 20 ) $str = "";
    if ( $actual_year == $this->y and $actual_month > $this->m ) $str = "";
    if ( $actual_year > $this->y ) $str = "";

    return $str . $users[ $u_id ]->get_full_name();
  }
}

?>
