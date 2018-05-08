<?php

require '../include/config.php';
require '../class/user.php';
require '../class/overview.php';
require "../template/overview.php";

// kontrola statusu prihláseného používateľa
$my_account = User::login();

// vytvor pole s informaciam o vsetkych pouzivateloch (potrebne pre vykresleneie prehladu)
$users = User::create_all_users();

// nastav rok a mesiac ( ak su neplatne nastavi aktualny rok a masiac )
$year = get_year();
$month = get_month();

// ak posles personal_id, zobrazi sa prehlad len daneho pouzivatela (napr. filter v indexy)
if ( get(["p_id"]) ) $pid = intval( get("p_id") );
else $pid = 0;

// ak posles title = 0, nezobrazi sa hlavicka prehladu s nazvom mesiaca, roku a posuvnikom
if ( get(["title"]) ) $title = intval( get("title") );
else $title = 1;

// ak je nastavene personal ID 2 ... kvoli refresom v kalendari
if ( get(["personal_id"]) ) $personal_id = intval( get("personal_id") );
else $personal_id = 0;

// vytvor nahlad
$overview = new Overview($year, $month, $pid, $personal_id);

// vykresli nahlad
echo $overview->run( $title );

?>
