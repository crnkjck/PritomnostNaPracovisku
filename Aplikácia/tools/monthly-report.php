<?php

require '../include/config.php';
require '../include/db_utils.php';
require '../class/user.php';
require '../class/overview.php';

// kontrola statusu prihláseného používateľa
$my_account = User::login(User::STATUS_SECRETARY);

// nastav rok a mesiac ( ak su neplatne nastavi aktualny rok a mesiac )
$year = get_year();
$month = get_month();

$report_data = [
  "year" => $year,
  "month" => $month,
  "month_sk" => $sk_months[$month],
  "personal_id_prefix" => $personal_id_prefix,
  "employees" => User::get_users(),
  "public_holidays" => Overview::get_public_holidays($year, $month),
  "absences" => Overview::get_absences($year, $month)
];

$jobname = preg_replace('/[^a-zA-Z0-9.]/', '-',
  sprintf("%04d-%02d-%s", $year, $month, $my_account->username)
);
list($tmpdir, $etc) = exec_or_die(
  "mktemp",
  ["--directory", "--tmpdir", "pritomnost-vykaz.$jobname.XXXXXXXXXX"]
);

$inpath = "$tmpdir/data.json";
$outfname = preg_replace('/[^a-zA-Z0-9.]/', '-',
  sprintf("%02d-dochadzka-%02d.xlsx", $month, $year % 100)
);
$outpath = "$tmpdir/$outfname";

file_put_contents($inpath, json_encode($report_data));
exec_or_die("../../../miniconda3/condabin/conda",
  ["run", "--no-capture-output",
   "./monthly-report.py", $inpath, $outpath
  ]);

header("Content-Description: Vykaz dochadzky za $year-$month");
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.$outfname.'"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($outpath));

if (readfile($outpath) === false) {
  exit(1);
}

exec_or_die("rm", ["-r", $tmpdir]);

?>
