<?php

require '../include/config.php';

if ( post(["email"]) ) $mail = post("email");
else exit();

$sql = $conn->prepare("SELECT id, username, email FROM users WHERE email = ? AND status > 0");
$sql->bind_param('s', $mail);
$sql->execute();
$sql = $sql->get_result();

if ( $u = $sql->fetch_assoc() ) {
  $d_pass = substr(sha1(time()), 0, 8);
  $e_pass = password_hash( $d_pass, PASSWORD_BCRYPT );

  $check = $conn->query("UPDATE users SET password = '$e_pass' WHERE id = '$u[id]'");
  if ( $check === TRUE ) {
    if ( $sending_mails ) {
      $email = $u['email'];
      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
      $headers .= 'From: noreply@pritomnost.dai.fmph.uniba.sk' . "\r\n";
      $text = "Vase nove prihlasovacie udaje...<br><br>Pouzivatelske meno: $u[username]<br>Heslo: $d_pass";
      mail($email, "Zmena hesla - Pritomnost na pracovisku", $text, $headers);
      echo "Email odoslaný.";
    }
    else echo "Chyba: mail-server.";
  }
  else echo "Operácia zlyhala.";
}
else echo "Zadaný email neexistuje.";

?>
