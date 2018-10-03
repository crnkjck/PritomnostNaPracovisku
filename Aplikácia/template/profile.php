<?php

function print_profile_edit($name, $surname, $username, $email) {
  return "
  <div class='content'>
    <div class='title_1'>
      Môj profil: $name $surname
    </div>

    <div id='info_container'></div>

    <div class='form'>
      <div>
        <label for='username'>Prihlasovacie meno</label>
        <input id='username' name='username' type='text' placeholder='Zadajte prihlasovacie meno' value='$username'>
      </div>

      <div>
        <label for='email'>Email</label>
        <input id='email' name='email' type='text' placeholder='Zadajte email' value='$email'>
      </div>

      <div>
        <label for='password_new_1'>Prihlasovacie heslo</label>
        <div class='info'><span class='fa fa-info-circle'></span> V prípade, že nechcete meniť pôvodné heslo, vynechajte túto kolónku.</div>
        <input id='password_new_1' name='password_new_1' type='password' placeholder='Zadajte nové heslo'><br>
        <input id='password_new_2' name='password_new_2' type='password' placeholder='Znova zadajte nové heslo'>
      </div>

      <div>
        <label for='password'>Potvrdenie údajov</label>
        <div class='info'><span class='fa fa-info-circle'></span> Pre potvrdenie zadaných údajov je nutné vložiť prihlasovacie heslo.</div>
        <input id='password' name='password' type='password' placeholder='Vaše heslo'><br>
      </div>
    </div>
    <div class='button_submit' onclick='profile_edit();'>Potvrdiť údaje</div>
  </div>
  ";
}

?>
