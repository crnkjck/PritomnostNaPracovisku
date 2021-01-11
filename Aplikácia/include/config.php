<?php

require "conn.php";

$main_url = "http://localhost/tis";

$sending_mails = false;

// PID používateľov, ktorí schvaľujú prácu doma a pracovné cesty
$request_validators = [822];

$printer_host = "print.dai.fmph.uniba.sk";
$printer = "dovolenka";
$printer_options = ['landscape', 'PageSize=A6'];

$department = 'Katedra aplikovanej informatiky';
$department_id = '107240';

$sk_months = ["", "Január", "Február", "Marec", "Apríl", "Máj", "Jún", "Júl", "August", "September", "Október", "November", "December"];
$sk_days = ["", "Pondelok", "Utorok", "Streda", "Štvrtok", "Piatok", "Sobota", "Nedela"];

$sk_types = [
    1 => "Práceneschopnosť",
    2 => "Pracovná cesta",
    3 => "Dovolenka",
    4 => "Práca doma",
    5 => "Iná neprítomnosť",
    6 => "Materská dovolenka",
    7 => "Rodičovská dovolenka"
];

const ABSENCE_ILL = 1;
const ABSENCE_TRAVEL = 2;
const ABSENCE_HOLIDAY = 3;
const ABSENCE_WORKFROMHOME = 4;
const ABSENCE_OTHER = 5;
const ABSENCE_MATERNAL = 6;
const ABSENCE_PARENTAL = 7;

$actual_year = intval(date("Y"));
$actual_month = intval(date("n"));
$actual_day = intval(date("j"));

$deadline = $conn->query("SELECT day FROM deadlines WHERE year = '$actual_year' AND month = '$actual_month'");
if ( $deadline = $deadline->fetch_assoc() ) $deadline = $deadline["day"];
else $deadline = 20;

function e($var) { echo $var; }

require "functions.php";
require "sha1sums.php";

?>
