<?php

function print_events( $year, $year_minus, $year_plus ) {
  return "
  <div class='content' id='events'>
    <div class='title_1'>Udalosti
      <div class='subtitle'>
          <a href='events.php?year=$year_minus' title='$year_minus'><span class='fa fa-chevron-circle-left'></span></a>
          $year
          <a href='events.php?year=$year_plus' title='$year_plus'><span class='fa fa-chevron-circle-right'></span></a>
      </div>
    </div>

    <div id='info_container'></div>

    <div class='add'>
      <div class='title'>Pridať udalosť pre rok $year</div>
      Popis: <input type='text' name='description' placeholder='Zadajte popis udalosti'><br>
      Dátum: <input type='text' name='day' placeholder='dd'> . <input type='text' name='month' placeholder='mm'> . 2018
      <div class='info'><span class='fa fa-info-circle'></span> Všetky záznamy pridané používateľmi pre tento deň budú odstránené.</div>
      <div class='button_submit' onclick='event_add($year);'>Pridať</div>
    </div>

    <div id='events_table' class='table_3'>
      <script>events_load($year);</script>
    </div>

  </div>
  ";
}

function print_events_table( $str ) {
  return "
  <table>
    <tr>
      <th>Dátum</th>
      <th colspan='2'>Popis udalosti</th>
    </tr>
    $str
  </table>
  ";
}

function print_events_table_row( $id, $date, $description ) {
  return "
  <tr id='event_$id'>
    <td>$date</td>
    <td>$description</td>
    <td title='Vymazať' onclick='event_remove( $id );'> <span class='fa fa-times'></span> </td>
  </tr>
  ";
}

?>
