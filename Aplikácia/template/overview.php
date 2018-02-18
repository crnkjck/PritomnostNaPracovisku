<?php

function print_overview_title ( $month_name, $year, $year_minus, $month_minus, $year_plus, $month_plus) {
  return "
  <div class='title'>
    <span class='fa fa-chevron-left' onclick='slide_overview($year_minus, $month_minus);'></span>
      $month_name $year
    <span class='fa fa-chevron-right' onclick='slide_overview($year_plus, $month_plus);'></span>
  </div>
  ";
}

function print_overview_filter ( $name, $surname ) {
  return "
  <div class='filter'>
    <strong>Filter:</strong>
      $surname $name
    <span class='fa fa-times' onclick='overview_set_user(-1);'></span>
  </div>
  ";
}

function print_overview_box ( $month_name, $year, $day, $holiday, $values ) {
  return "
  <div class='box'>
    <div class='title $holiday'>$day. $month_name $year</div>
    <table><tbody>
      $values
    </tbody></table>
  </div>
  ";
}

function print_overview_box_value ( $id, $remove_button, $name, $surname = "", $type = "", $time = "", $desc = "" ) {
  return "
  <tr class='value value_$id'>
    <td class='name' > $remove_button $surname $name </td>
    <td class='type'> $type </td>
    <td class='time'> $time </td>
  </tr>
  <tr class='desc'><td colspan='3'>$desc</td></tr>
  ";
}

function print_overview_box_value_remove ( $y, $m, $name, $surname, $absence_id ) {
  return "
    <span onclick='overview_remove_value( $absence_id, \"$name $surname\"); reload_calndar($y, $m);' class='fa fa-times admin_icon'></span>
  ";

}


?>
