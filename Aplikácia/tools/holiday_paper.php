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

    <h1>DOVOLENKA</h1>

    <table>

      <tr>
        <td>Priezvisko, meno</td>
        <td class="tC B tVal" colspan="3"><?php echo "$surname $name"; ?></td>
        <td>Osobné číslo</td>
        <td class="tC B tVal" colspan="3"><?php echo $pesonal_id; ?></td>
      </tr>

      <tr>
        <td>Útvar</td>
        <td class="tC tVal" colspan="3">Katedra aplikovanej informatiky</td>
        <td>Číslo útvaru</td>
        <td colspan="3"></td>
      </tr>

      <tr>
        <td colspan="4">žiada o dovolenku na zotavenie za kalendárny rok</td>
        <td colspan="4"></td>
      </tr>

      <tr>
        <td class="cw2 tR">od</td>
        <td class="cw2 tC B tVal"><?php echo $from_time; ?></td>
        <td class="cw1 tR">do</td>
        <td class="cw2 tC B tVal"><?php echo $to_time; ?></td>
        <td class="cw2">vrátane t.j.</td>
        <td class="cw1 tC B tVal"><?php echo $num_of_days; ?></td>
        <td class="cw2" colspan="2">pracovných dní.</td>
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
        <td class="tC rBT rBR" colspan="2">Dátum</td>
        <td class="rBL rBR rBT" colspan="2"></td>
        <td class="tC rBT rBL" colspan="4">Podpis pracovníka</td>
      </tr>

      <tr>
        <td colspan="3"></td>
        <td>Dátum</td>
        <td>Ved. útvaru</td>
        <td colspan="3">Pers. útvar</td>
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
        <td class="rBR" colspan="2">Z tejto dovolenky sa skutočne čerpalo</td>
        <td class="rBL rBR" colspan="2"><span class="dotfill"></span></td>
        <td class="rBL" colspan="4">pracovných dní.</td>
      </tr>


    </table>
    <style>
      body { font-size: 10pt; font-family: Helvetica, Arial, sans-serif; }
      h1, table { min-width: 15cm; max-width: 19cm; }
      h1, .h1 { font-size: 200%; font-weight: bold; text-align: center; letter-spacing: .2em; margin: 0; padding: 5pt; }
      table { border-collapse: collapse; box-sizing: border-box; border: 1.2pt solid black; }
      @media print {
      	h1, table { width: 100%; margin: 0 auto; }
      }
      td { border: .4pt solid black; padding: 5pt 5pt; }

      .cw1 { width: 8.33333%; }
      .cw2 { width: 16.66667%; }

      .tC { text-align: center; }
      .tR { text-align: right; }

      .rBT { border-top: none; }
      .rBB { border-bottom: none; }
      .rBR { border-right: none; }
      .rBL { border-left: none; }

      .tVal { font-family: Times, "Times New Roman", serif; }

      .pt30 { padding-top: 1cm; }

      .dotfill { display: inline-block; border-bottom: 1.33333pt dotted black; width: 100%; height: 1.2em; }

      .B { font-weight: bold; font-size: 18px; }

    </style>

  </body>
</html>
