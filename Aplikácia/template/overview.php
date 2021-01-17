<?php

function print_overview_title ( $month, $year, $additional_content = "") {
  global $sk_months;
  list($year_minus, $month_minus) = month_minus($year, $month);
  list($year_plus, $month_plus) = month_plus($year, $month);

  return "
  <div class='title'>
    <span class='fa fa-chevron-left' onclick='slide_overview($year_minus, $month_minus);'></span>
      ${sk_months[$month]} $year
    <span class='fa fa-chevron-right' onclick='slide_overview($year_plus, $month_plus);'></span>
    $additional_content
  </div>
  ";
}

function print_report_link ( $month, $year ) {
  global $main_url;
  $month = urlencode($month);
  $year = urlencode($year);
  return "<a class='button_submit button_download' href='${main_url}tools/monthly-report.php?month=$month&year=$year'
      ><i class='fa fa-file-excel-o'></i>
    Stiahnuť výkaz
   </a>
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

function print_overview_box_value_remove ( $y, $m, $name, $surname, $absence_id, $personal_id = 0 ) {
  return "
    <span onclick='overview_remove_value( $absence_id, \"$name $surname\"); reload_calndar($y, $m, $personal_id);' class='fa fa-times admin_icon'></span>
  ";

}


?>
