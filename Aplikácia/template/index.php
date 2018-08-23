<?php

function print_index_person ( $id, $name, $surname, $personal_id ) {
  return "
  <div class='value person' id='person_$id' onclick='overview_set_user($id);'>
    $surname $name <span>$personal_id</span>
  </div>
  ";
}

function print_index( $persons, $y, $m ) {
  global $deadline;

  return "
  <div class='content' id='overview'>

    ".message( "info", "<b>V tomto mesiaci môžete svoju dovolenku a&nbsp;práceneschopnosť pridávať a&nbsp;editovať do $deadline. dňa.</b> <br> Po tomto dni sa obráťte na pani sekretárku. Neprítomnosť z&nbsp; ostatných dôvodov je možné zadávať do konca mesiaca." )."

    <div class='side_table'>
      <div class='title'>Prehľad zamestnancov</div>
      $persons
    </div>

    <div id='overview_table'></div>
    <script>slide_overview($y, $m);</script>

    <div class='spacer'></div>
  </div>
  ";

}

?>
