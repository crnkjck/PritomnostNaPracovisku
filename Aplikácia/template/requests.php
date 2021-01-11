<?php

function print_requests( $year, $year_minus, $year_plus, $str ){
  return "
  <div class='content' id='requests'>
    <div class='title_1'>Žiadosti
      <div class='subtitle'>
          <a href='requests.php?year=$year_minus' title='$year_minus'><span class='fa fa-chevron-circle-left'></span></a>
          $year
          <a href='requests.php?year=$year_plus' title='$year_plus'><span class='fa fa-chevron-circle-right'></span></a>
      </div>
    </div>

    <div id='info_container'></div>

    <div class='table_3'>
      <table>
        <tr>
          <th>Dátum</th>
          <th>Popis</th>
          <th>Schválenie</th>
        </tr>
        $str
      </table>
    </div>

  </div>
  ";
}

function print_requests_table_row ( $id, $date, $time, $user_name, $type, $description, $confirmed ) {
  if ( $confirmed ) {
    $class = 'enable';
    $confstr = 'Schválená';
  } else {
    $class = 'disable';
    $confstr = 'Schváliť';
  }
  return "
  <tr id='request_$id'>
    <td>$date <div>$time</div></td>
    <td>$user_name &ndash; $type<br><span class='desc'>$description</span></td>
    <td onclick='request_set($id);' id='request_check_$id' class='$class' title='$confstr'><span class='fa fa-check'></span></td>
  </tr>
  ";
}

function print_terms_table_row_empty() {
  return "<tr><td colspan='3'>Žiadne záznamy...</td></tr>";
}

?>
