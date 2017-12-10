<?php
session_start();

$main_url = "http://localhost/tis";

$sk_months = ["", "Január", "Február", "Marec", "Apríl", "Máj", "Jún", "Júl", "August", "September", "Október", "November", "December"];
$sk_types = ["", "Práceneschopnosť", "Pracovná cesta", "Dovolenka", "Práca doma", "Iná neprítomnosť"];

$actual_year = intval(date("Y"));
$actual_month = intval(date("n"));
$actual_day = intval(date("j"));
?>
