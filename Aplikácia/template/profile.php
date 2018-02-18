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
        <span>Prihlasovacie meno</span>
        <input name='username' type='text' placeholder='Zadajte prihlasovacie meno' value='$username'>
      </div>

      <div>
        <span>Email</span>
        <input name='email' type='text' placeholder='Zadajte email' value='$email'>
      </div>

      <div>
        <span>Prihlasovacie heslo</span>
        <div class='info'><span class='fa fa-info-circle'></span> V prípade, že nechcete meniť pôvodné heslo, vynechajte túto kolónku.</div>
        <input name='password_new_1' type='password' placeholder='Zadajte nové heslo'><br>
        <input name='password_new_2' type='password' placeholder='Znova zadajte nové heslo'>
      </div>

      <div>
        <span>Potvrdenie údajov</span>
        <div class='info'><span class='fa fa-info-circle'></span> Pre potvrdenie zadaných údajov je nutné vložiť prihlasovacie heslo.</div>
        <input name='password' type='password' placeholder='Vaše heslo'><br>
      </div>
    </div>
    <div class='button_submit' onclick='profile_edit();'>Potvrdiť údaje</div>
  </div>
  ";
}

?>
