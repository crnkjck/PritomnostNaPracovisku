<?php
function post( $arr ) {
  if ( is_string( $arr ) ) return $_POST[$arr];
  foreach ( $arr as $a ) { if ( !isset($_POST[$a]) ) return 0; }
  return 1;
}

if ( post(["name", "surname", "personal_id", "from_time", "to_time", "num_of_days"]) ){
  $name = post("name");
  $surname = post("surname");
  $pesonal_id = post("personal_id");
  $from_time = post("from_time");
  $to_time = post("to_time");
  $num_of_days = post("num_of_days");
}
else exit();
?>

<html>
  <head>
    <meta charset='utf-8'>
    <title>Dovolenkový lístok</title>
  </head>

  <body>

    <table>

      <tr>
        <td style="text-align: center; font-size: 24px; font-weight: bold;" colspan="8">DOVOLENKA</td>
      </tr>

      <tr>
        <td>Priezvisko,<br> meno</td>
        <td class="tC B" colspan="3"><?php echo "$surname $name"; ?></td>
        <td>Osobné číslo</td>
        <td class="tC B" colspan="3"><?php echo $pesonal_id; ?></td>
      </tr>

      <tr>
        <td>Útvar</td>
        <td colspan="3"></td>
        <td>Číslo útvaru</td>
        <td colspan="3"></td>
      </tr>

      <tr>
        <td colspan="4">žiada o dovolenku na zotavenie za kalendárny rok:</td>
        <td colspan="4"></td>
      </tr>

      <tr>
        <td class="tR" style="width: 180px;">od:</td>
        <td class="tC B" style="width: 240px;"><?php echo $from_time; ?></td>
        <td class="tR" style="width: 90px;">do:</td>
        <td class="tC B" style="width: 210px;"><?php echo $to_time; ?></td>
        <td style="width: 210px;">vrátane t.j</td>
        <td class="tC B" style="width: 90px;"><?php echo $num_of_days; ?></td>
        <td style="width: 210px;" colspan="2">pracovných dní</td>
      </tr>

      <tr>
        <td colspan="2">Miesto pobytu na dovolenke:</td>
        <td colspan="6"></td>
      </tr>

      <tr>
        <td class="tC rBB pt30 rBR" colspan="2">..................................................................</td>
        <td class="rBL rBR rBB" colspan="2"></td>
        <td class="tC rBB pt30 rBL" colspan="4">..................................................................</td>
      </tr>

      <tr>
        <td class="tC rBT rBR" colspan="2">dátum</td>
        <td class="rBL rBR rBT" colspan="2"></td>
        <td class="tC rBT rBL" colspan="4">podpis pracovníka</td>
      </tr>

      <tr>
        <td colspan="3"></td>
        <td>Dátum</td>
        <td>Ved. útvaru</td>
        <td colspan="3">Personál. útvaru</td>
      </tr>

      <tr>
        <td colspan="3">Schválil</td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
      </tr>

      <tr>
        <td colspan="3">Skutočný nástup dovolenky</td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
      </tr>

      <tr>
        <td colspan="3">Nástup do zamestania po dovolenke</td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
      </tr>

      <tr>
        <td colspan="2">Z tejto dovolenky sa skutočne čerpalo</td>
        <td class="rBR" colspan="3"></td>
        <td class="rBL" colspan="3">pracovných dní</td>
      </tr>


    </table>
    <style>
      table { width: 1230px; border-collapse: collapse; }
      td { border: 1px solid black; padding: 10px 10px; }

      .tC { text-align: center; }
      .tR { text-align: right; }

      .rBT { border-top: none; }
      .rBB { border-bottom: none; }
      .rBR { border-right: none; }
      .rBL { border-left: none; }

      .pt30 { padding-top: 30px; }

      .B { font-weight: bold; font-size: 18px; }

    </style>

  </body>
</html>
