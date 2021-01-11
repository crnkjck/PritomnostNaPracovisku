<?php

function print_calendar($year, $month) {
  return "
  <div class='content' id='calendar'>
    <script> reload_calndar($year, $month); </script>
  </div>
  ";
}

function print_calendar_holidays_empty () {
  return "<div class='empty'>V tomto mesiaci ste nežiadali o&nbsp;dovolenku.</div>";
}

function print_calendar_holidays_value ( $user, $year, $from_time, $to_time, $num_of_days, $request_date ) {
  return "
    <div class='value'>
      <h3>$from_time &ndash; $to_time $year <small>(" . sk_days($num_of_days) . ")</small></h3>
      <button class='button_submit button_print' onclick='holiday_paper(
                          this,
                          $user->personal_id, $year,
                          \"$from_time\", \"$to_time\", $num_of_days,
                          \"$request_date\");'
        >Vytlačiť</button>
    </div>
  ";
}

function print_calendar_holidays ( $data ) {
  return "
  <div class='side_table'>
    <div class='title'>Dovolenkové lístky</div>
    $data
  </div>
  ";
}

function print_calendar_overview ($year, $month, $id, $personal_id = 0) {
  return "
  <div id='overview_table'> <script>slide_overview($year, $month, $id, 0, $personal_id);</script> </div>
  <div class='spacer'></div>
  ";
}

function print_calendar_inserted_script ($year, $month, $personal_id) {
  return "<script> reload_calndar($year, $month, $personal_id); </script>";
}

function print_calendar_set_form_days ( $date, $name ) {
  return "$date ($name)<br>";
}

function print_calendar_set_form_single () {
  return "
  <div class='input_title'>Neprítomnosť v čase</div>

  <div class='input_value'>
    <label><input type='radio' name='c_time_type' value='1' onchange='show_time();' checked><span>Celý deň</span></label>
    <label><input type='radio' name='c_time_type' value='2' onchange='show_time();'><span>Vybrať časové rozmedzie</span></label>
  </div>
  <div class='spacer'></div>

  <div class='input_time'>
    <div>Od: <input class='input_text' type='text' name='c_from_h' placeholder='0-23'> hod. <input class='input_text' type='text' name='c_from_m' placeholder='0-55'> min.</div>
    <div>Do: <input class='input_text' type='text' name='c_to_h' placeholder='0-23'> hod. <input class='input_text' type='text' name='c_to_m' placeholder='0-55'> min.</div>
  </div>
  ";
}

function print_calendar_set_form_types ( $key, $value, $checked = "" ) {
  return "<label><input type='radio' name='c_type' value='$key' onchange='show_subtypes();' $checked><span>$value</span></label>";
}

function print_calendar_set_form ( $count, $days, $single, $year, $month, $date1, $date2, $types, $personal_id, $admin_str ) {
  return "
  <div class='title_1'>Pridať neprítomnosť</div>
  Počet vybraných dní: $count<br>
  $days
  $single
  <div class='input_title'>Zverejnenie</div>

  <div class='input_value'>
    <label><input type='radio' name='c_public' value='1'><span>Zverejniť</span></label>
    <label><input type='radio' name='c_public' value='0' checked><span>Nezverejňovať</span></label>
  </div>
  <div class='spacer'></div>

  <div class='input_title'>Dôvod neprítomnosti</div>
  <div class='input_value'>
    $types
  </div>
  <div class='spacer'></div>

  <div class='input_title'>Popis</div>
  <input class='input_text' type='text' name='c_description' placeholder='nepovinné'>
  <div class='spacer'></div>

  <div class='button_submit add_absence' onclick='calendar_set($year, $month, $date1, $date2, $personal_id);'>Potvrdiť</div> $admin_str
  ";
}




function print_calendar_table_td_null () {
  return "<td class='empty'></td>";
}

function print_calendar_table_td ( $day, $class, $icon ) {
  return "<td onclick='calendar_click($day);' class='active $class day_$day'><span class='$icon'></span> $day</td>";
}

function print_calendar_table_tr ($data) {
  return "<tr>$data</tr>";
}

function print_calendar_holiday_script ( $remaining ) {
  return "<script>$('#holiday_remaining').html('$remaining');</script>";
}

function print_calendar_table($y, $m, $yL, $mL, $yR, $mR, $data, $personal_id, $admin_str){
  global $sk_months;

  return "
  <div class='title_1'>
    Kalendár
  </div>

  $admin_str

  <table id='calendar_table'>

  <tr>
    <th onclick='reload_calndar($yL, $mL);'><span class='fa fa-chevron-left'></span></th>
    <th colspan='5'>$sk_months[$m] $y</th>
    <th onclick='reload_calndar($yR, $mR);'><span class='fa fa-chevron-right'></span></th>
  </tr>
  <tr><th>Po</th> <th>Ut</th> <th>St</th> <th>Št</th> <th>Pia</th> <th>So</th> <th>Ne</th></tr>
  $data
  </table>

  <div class='input_help'>Vyberte deň alebo rozmedzie dní. Rozmedzie zadáte kliknutím na počiatočný deň a následne kliknutím na koncový deň.</div>

  <div class='buttons'>
    <div class='button_submit' id='empty_add'>Vyberte deň alebo rozmedzie</div>
    <div class='button_submit hidden' id='single_add' onclick='calendar_add($y, $m, $personal_id);'>Pridať neprítomnosť pre deň</div>
    <div class='button_submit hidden' id='multiple_add' onclick='calendar_add($y, $m, $personal_id);'>Pridať neprítomnosť pre rozmedzie</div>
  </div>

  <div class='spacer'></div>
  ";
}


?>
