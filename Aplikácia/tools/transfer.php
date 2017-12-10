<?php
/*

$db1 = new mysqli("localhost", "root", "root", "dochadzka");
$db2 = new mysqli("localhost", "root", "root", "tis2");

if ($db1->connect_error or $db2->connect_error) {
    die("Connection failed.");
}

*/

/*$result = $db1->query("SELECT * FROM users");

while ( $r = $result->fetch_assoc() ){
	$s = $r['typ'];
	if ( $r['aktivny'] == 0 ) $s = 0;

	$db2->query("INSERT INTO users (personal_id, login, password, name, surname, title, email, status)
		VALUES ($r[id_user], '$r[login_name]', '$r[login_password]', '$r[meno]', '$r[priezvisko]', '$r[titul]', '$r[mail]', $s)");
}*/

/*
$result2 = $db1->query("SELECT * FROM nepritomnost");


$arr = array();
$result3 = $db1->query("SELECT * FROM users");
while ( $r = $result2->fetch_assoc() ) {
  $arr[$r['personal_id']] = $r['id'];
}

while ( $r = $result2->fetch_assoc() ) {
	$d1 = "$r[hodina_od]:$r[minuta_od]:00";
	$d2 = "$r[hodina_do]:$r[minuta_do]:00";

	$db2->query("INSERT INTO absence (id, user_id, date_time, from_time, to_time, description, type, insert_time, public, confirmation)
		VALUES ($r[id], $arr[user_id], FROM_UNIXTIME($r[date]), '$d1', '$d2', '$r[poznamka]', $r[druh], FROM_UNIXTIME($r[timestamp]), $r[public], $r[waiting_confirmation])");
}
*/

$conn = new mysqli("localhost", "root", "", "tis2");

$arr = [];
$sql = $conn->query("SELECT id, personal_id FROM users");

while ( $s = $sql->fetch_assoc() ) $arr[ $s["personal_id"] ] = $s["id"];

foreach ( $arr as $p_id => $id ) {
  $conn->query("UPDATE absence SET user_id = '$id' WHERE user_id = '$p_id'");
}

?>
