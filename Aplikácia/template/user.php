<?php

function print_user_add ( $id, $personal_id, $name, $surname, $email, $username, $holidays_budget, $status ) {
  global $actual_year;

  $st0 = $st1 = $st2 = $st3 = "";
  if ( $status == 0 ) $st0 = "checked";
  if ( $status == 1 ) $st1 = "checked";
  if ( $status == 2 ) $st2 = "checked";
  if ( $status == 3 ) $st3 = "checked";

  $header = "Pridať nového používateľa";
  if ( $name && $surname ) $header = "Upraviť používateľa: $name $surname";

  $pass_info = "";
  if ( $id ) $pass_info = "<div class='info'><span class='fa fa-info-circle'></span> V prípade, že nechcete meniť pôvodné heslo, vynechajte túto kolónku.</div>";

  return "
  <div class='content'>

    <div class='title_1'>$header</div>

    <div id='info_container'></div>

    <div class='form'>
      <div>
        <span>Počet dní dovolenky (pre rok $actual_year)</span>
        <input name='holidays_budget' type='text' placeholder='Zadajte počet dní' value='$holidays_budget'>
      </div>

      <div>
        <span>Osobné číslo</span>
        <input name='personal_id' type='text' placeholder='Zadajte osobné číslo' value='$personal_id'>
      </div>

      <div>
        <span>Meno</span>
        <input name='name' type='text' placeholder='Zadajte meno' value='$name'>
      </div>

      <div>
        <span>Priezvisko</span>
        <input name='surname' type='text' placeholder='Zadajte priezvisko' value='$surname'>
      </div>

      <div>
        <span>Email</span>
        <input name='email' type='text' placeholder='Zadajte email' value='$email'>
      </div>

      <div>
        <span>Prihlasovacie meno</span>
        <input name='username' type='text' placeholder='Zadajte prihlasovacie meno' value='$username'>
      </div>

      <div>
        <span>Prihlasovacie heslo</span>
        $pass_info
        <input name='password' type='text' placeholder='Zadajte prihlasovacie heslo'><br>
      </div>

      <div class='status'>
        <span>Oprávnenia</span>
        <input name='status' type='radio' value='0' $st0> Deaktivovaný<br>
        <input name='status' type='radio' value='1' $st1> Používateľ<br>
        <input name='status' type='radio' value='2' $st2> Sekretariát<br>
        <input name='status' type='radio' value='3' $st3> Administrátor
      </div>

      <div class='button_submit' onclick='user_edit( $personal_id );'>Potvrdiť</div>
    </div>

  </div>
  ";
}

?>
