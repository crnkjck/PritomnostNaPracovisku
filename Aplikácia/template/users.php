<?php

function print_users_char ( $char ) {
  return "<div class='char'>$char</div>";
}

function print_users_person ( $id, $name, $surname, $personal_id, $class, $budget, $spend ) {
  $b = $budget;
  if ( !$budget ) $b = "<strong>$budget</strong>";

  return "
  <div class='person person_$id'>
    <b>$surname $name</b>
    <span class='personal_id'>#$personal_id</span>
    <span class='icons'>
      <span class='$class'><span class='fa fa-plane'></span> $spend / $b</span>
      <a href='user.php?personal_id=$personal_id'><span class='fa fa-edit'></span></a>
    </span>
  </div>
  ";
}

function print_users ( $data, $active, $no_active ) {
  return "
  <div id='users' class='content'>
    <div class='title_1'>
      Používatelia
      <div class='subtitle'>
        Zobraziť:
        <a href='users.php' class='active_$active'>Aktívnych</a> |
        <a href='users.php?deactivated' class='active_$no_active'>Deaktivovaných</a>
      </div>
    </div>

    <a href='user.php' class='button_submit'>+ Pridať nového používateľa</a>

    <div class='table'>
      $data
    </div>
  </div>
  ";
}

?>
