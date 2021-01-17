<?php

function sk_format_date( $date ) {
  return date("j. n. Y", strtotime( $date ) );
}

function sk_format_short_date( $date ) {
  return date("j. n.", strtotime( $date ) );
}

function format_float_max2dp( $days ) {
  if (floor($days) == $days) {
    return floor($days);
  }
  if (round($days*100) % 10 == 0) {
    return sprintf("%.1f", $days);
  }
  return sprintf("%.2f", $days);
}

function sk_days( $num ) {
    if ($num == 1) {
        return "1 deň";
    } elseif ($num >= 2 && $num <= 4) {
        return "$num dni";
    } else {
        return "$num dní";
    }
}

function display_time( $from, $to ) {
  if ( !$from or !$to ) return "";
  $t1 = date( "H:i", strtotime($from) );
  $t2 = date( "H:i", strtotime($to) );
  if ( $t1 == "08:00" && $t2 == "16:00" )
    return "Celý deň";
  return "<strong>$t1 - $t2</strong>";
}

function message ( $type, $text, $hidder = 0 ) {
  $icon = "";
  if ( $type == "error" ) $icon = "fa-exclamation-triangle";
  if ( $type == "info" ) $icon = "fa-info-circle";
  if ( $type == "ok" ) $icon = "fa-check-circle";

  $js = "";
  if ( $hidder ) {
    $js = "onclick='hidder(this);'";
  }

  return "<div class='$type message' $js><span class='fa $icon'></span> $text<div class='spacer'></div></div>";
}

function holiday_hours_interval( $from, $to ) {
  $hours = ( strtotime($to) - strtotime($from) ) / 3600;
  if ( $hours <= 2 ) return 0.25;
  if ( $hours <= 4 ) return 0.5;
  if ( $hours <= 6 ) return 0.75;
  return 1;
}

function session( $arr ) {
  if ( is_string( $arr ) ) return $_SESSION[$arr];

  foreach ( $arr as $a ) {
    if ( !isset($_SESSION[$a]) ) return 0;
  }
  return 1;
}

function post( $arr ) {
  if ( is_string( $arr ) ) return $_POST[$arr];

  foreach ( $arr as $a ) {
    if ( !isset($_POST[$a]) ) return 0;
  }
  return 1;
}

function get( $arr ) {
  if ( is_string( $arr ) ) return $_GET[$arr];

  foreach ( $arr as $a ) {
    if ( !isset($_GET[$a]) ) return 0;
  }
  return 1;
}

function get_year() {
  $year = idate("Y");
  if ( isset( $_GET["year"] ) ) {
    $t_year = intval( $_GET["year"] );
    if ( $t_year >= 2000 && $t_year <= 2500 ) $year = $t_year;
  }
  return $year;
}

function get_month() {
  $month = idate("n");
  if ( isset( $_GET["month"] ) ) {
    $t_month = intval( $_GET["month"] );
    if ( $t_month >= 1 && $t_month <= 12 ) $month = $t_month;
  }
  return $month;
}

function month_minus( $year, $month ) {
  $year_minus = $year;
  $month_minus = $month-1;
  if ( $month_minus < 1 ) { $year_minus -= 1; $month_minus = 12; }
  return [$year_minus, $month_minus];
}

function month_plus( $year, $month ) {
  $year_plus = $year;
  $month_plus = $month+1;
  if ( $month_plus > 12 ) { $year_plus += 1; $month_plus = 1; }
  return [$year_plus, $month_plus];
}

function first_char( $str ) {
  return mb_substr($str, 0, 1, "utf-8");
}

function edit_date( $y, $m, $type ) {
  global $deadline, $actual_year, $actual_month, $actual_day;

  if ( $type == ABSENCE_ILL || $type == ABSENCE_HOLIDAY ) $protection = true;
  else $protection = false;

  if ( $actual_year < $y ) return true;
  if ( $actual_year == $y && $m > $actual_month ) return true;
  if ( ($actual_year == $y && $m == $actual_month) && (!$protection || $actual_day <= $deadline) ) return true;
  return false;
}

function set_plain_output() {
  header('Content-Type: text/plain; charset=UTF-8');
}

function exec_or_die($cmd, $args) {
  $cmd = join(" ", array_merge(
    [ escapeshellcmd($cmd) ],
    array_map('escapeshellarg', $args)
  ));
  $output = array();
  $return_val = 0;
  $lastline = exec($cmd . ' 2>&1', $output, $return_val);
  if ($return_val != 0) {
    error_log("Failed to execute: $cmd");
    error_log(join("\n", $output));
    header("HTTP/1.0 500 Internal server error");
    exit($return_val);
  }
  return array($lastline, $output);
}

?>
