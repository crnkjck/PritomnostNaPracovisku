<?php

function print_terms( $year, $year_minus, $year_plus, $str ) {
  return "
  <div class='content' id='terms'>
    <div class='title_1'>Termíny
      <div class='subtitle'>
          <a href='terms.php?year=$year_minus' title='$year_minus'><span class='fa fa-chevron-circle-left'></span></a>
          $year
          <a href='terms.php?year=$year_plus' title='$year_plus'><span class='fa fa-chevron-circle-right'></span></a>
      </div>
    </div>

    <div id='info_container'></div>

    <div class='table_3'>
      <table>
        <tr>
          <th>Mesiac</th>
          <th colspan='2'>Deň v mesiaci, do ktorého treba zadať absenciu</th>
        </tr>
        $str
      </table>
    </div>
    <br>
    <div class='button_submit' onclick='terms_set( $year );'>Uložiť</div>
  </div>
  ";
}

function print_terms_table_row( $day, $month_name, $value ) {
  return "<tr><td>$month_name</td> <td colspan='2'><input name='m$day' placeholder='Zadajte deadline' value='$value'></td></tr>";
}


?>
