<?php

class Day {
  var $d = 0, $m = 0, $y = 0;
  var $user_id = 0;
  var $holiday = false;
  var $type = 0;
  var $description = "";
  var $public = 1;
  var $confirmation = 0;
  var $from_time = "08:00:00";
  var $to_time = "16:00:00";
  var $insert_time = null;

  function __constructor( $d, $m, $y, $user_id ) {
    global $conn;

    $this->d = $d;
    $this->m = $m;
    $this->y = $y;
    $this->user_id = $user_id;

    $holiday = $conn->query( "SELECT * FROM holiday WHERE date_time = '$this->y-$this->m-$this->d'" );

    if ( $holiday = $holiday->fetch_assoc() ){
      $this->holiday = true;
    }

    $day = $conn->query( "SELECT * FROM absence WHERE user_id = '$this->user_id' AND date_time = '$this->y-$this->m-$this->d'" );

    if ( $day = $day->fetch_assoc() ) {
      $this->type = $day['type'];
      $this->description = $day['description'];
      $this->public = $day['public'];
      $this->confirmation = $day['confirmation'];
      $this->from_time = $day['from_time'];
      $this->to_time = $day['to_time'];
      $this->insert_time = $day['insert_time'];
    }
  }
}

?>
