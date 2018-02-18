<?php

class User {
  var $id = 0;
  var $personal_id = 0;
  var $status = 0;
  var $username = "";
  var $name = "";
  var $surname = "";
  var $email = "";
  var $last_login = "";
  var $holidays_budget = 0;
  var $holidays_spend = 0;
  var $user = false, $request_validator = false, $super_user = false, $admin = false;

  static function get( $personal_id ) {
    global $conn, $request_validators;

    $user = new User;
    $sql = $conn->query("SELECT * FROM users WHERE personal_id = '$personal_id'");

    if ( $u = $sql->fetch_assoc() ) {
      $user->username = $u['username'];
      $user->name = $u['name'];
      $user->surname = $u['surname'];
      $user->email = $u['email'];
      $user->id = $u['id'];
      $user->personal_id = $u['personal_id'];
      $user->status = $u['status'];
      $user->last_login = $u['last_login'];
    }

    $sql = $conn->query("SELECT from_time, to_time FROM absence WHERE user_id = '$user->id' AND YEAR(date_time) = YEAR(NOW()) AND type = '3'");
    while ( $time = $sql->fetch_assoc() ) {
      $user->holidays_spend += holiday_hours_interval( $time["from_time"], $time["to_time"] );
    }

    $sql = $conn->query("SELECT num FROM holidays_budget WHERE user_id = '$user->id' AND year = YEAR(NOW())");
    if ( $n = $sql->fetch_assoc() )
      $user->holidays_budget = $n["num"];

    if ( $user->status > 0 ) $user->user = true;
    if ( $user->status == 2 ) $user->super_user = true;
    if ( $user->status == 3 ) $user->admin = true;

    if ( in_array($user->personal_id, $request_validators) ) $user->request_validator = true;

    return $user;
  }

  static function login( $security = 0, $request_validation = 0 ) {
    global $conn;

    if ( get(["logout"]) ) {
      session_unset();
      session_destroy();
      header('Location: index.php');
    }

    if ( post(["login_username","login_password"]) ) {
      $username = post("login_username");
      $password = post("login_password");

      $sql = $conn->prepare("SELECT personal_id, password FROM users WHERE username = ? AND status > 0");
      $sql->bind_param('s', $username);
      $sql->execute();
      $sql = $sql->get_result();

      if ( $u = $sql->fetch_assoc() ) {
        $p_id = $u['personal_id'];
        if ( password_verify( $password, $u['password'] )  ) {
          $token = sha1( time()."" );
          $conn->query("UPDATE users SET last_login = NOW(), token = '$token' WHERE personal_id = '$p_id'");
          $_SESSION["personal_id"] = $p_id;
          $_SESSION["token"] = $token;
          header('Location: index.php');
        }
      }
    }

    if ( session(["token", "personal_id"]) ) {
      $token = $_SESSION["token"];
      $p_id = $_SESSION["personal_id"];

      $sql = $conn->query("SELECT id FROM users WHERE token = '$token' AND personal_id = '$p_id'");
      if ( $sql->fetch_assoc() ) {
        $user = User::get( $p_id );
      }
    }
    else
      $user = new User;

    if ( $user->status >= $security && ( !$request_validation || $user->request_validator ) )
      return $user;
    else {
      header('Location: index.php');
      exit();
    }
    return $user;
  }

  static function create_all_users( $status = 1 ) {
    global $conn;

    $str = "status > 0";
    if ( $status == 0 ) $str = "status = 0";

    $arr = [];
    $sql = $conn->query("SELECT id, personal_id FROM users WHERE $str ORDER BY surname, name");
    while ( $u = $sql->fetch_assoc() )
      $arr[ $u["id"] ] = User::get( $u["personal_id"] );
    return $arr;
  }

  function holiday_budget_update() {
    global $conn, $actual_year;

    if ( $this->id == 0 ) return false;

    $sql = $conn->query( "SELECT * FROM holidays_budget WHERE user_id = '$this->id' AND year = '$actual_year'" );

    if ( $sql->fetch_assoc() ) {
      return $conn->query("UPDATE holidays_budget SET num = '$this->holidays_budget' WHERE user_id = '$this->id' AND year = '$actual_year'") === TRUE;
    }
    else {
      return $conn->query("INSERT INTO holidays_budget (user_id, num, year) VALUES ('$this->id', '$this->holidays_budget', '$actual_year')") === TRUE;
    }
  }

  function admin_update( $password ) {
    global $conn;

    if ( $this->id == 0 ) return false;
    if ( !$this->personal_id || !$this->name || !$this->surname || !$this->email || !$this->username ) return false;

    $str = "";
    if ( $password ) {
      $password_hash = password_hash( $password, PASSWORD_BCRYPT );
      $str = ", password = '$password_hash'";
    }

    $sql = $conn->prepare("UPDATE users SET personal_id = '$this->personal_id', name = ?, surname = ?,
                          email = ?, username = ?, status = '$this->status' $str WHERE id = '$this->id'");
    $sql->bind_param("ssss", $this->name, $this->surname, $this->email, $this->username);

    $budget = $this->holiday_budget_update();

    return $sql->execute();
  }

  function insert( $password ) {
    global $conn;

    if ( $this->id != 0 ) return false;
    if ( !$this->personal_id || !$this->name || !$this->surname || !$this->email || !$this->username || !$password ) return false;


    $password_hash = password_hash( $password, PASSWORD_BCRYPT );

    $sql = $conn->prepare("INSERT INTO users (personal_id, name, surname, email, username, password, status)
                          VALUES ('$this->personal_id', ?, ?, ?, ?, '$password_hash', '$this->status')");
    $sql->bind_param("ssss", $this->name, $this->surname, $this->email, $this->username);


    if ( $sql->execute() ) {
      $user = User::get( $this->personal_id );
      $this->id = $user->id;
      $this->holiday_budget_update();
      return true;
    }

    return false;
  }

  function update( $password ) {
    global $conn;
    if ( $this->id == 0 ) return false;
    if ( !$this->control_password( $password ) ) return false;

    $sql = $conn->prepare("UPDATE users SET email = ?, username = ? WHERE id = '$this->id'");
    $sql->bind_param("ss", $this->email, $this->username);

    return $sql->execute();
  }

  function control_password( $password ) {
    global $conn;

    $sql = $conn->query("SELECT password FROM users WHERE id = '$this->id'");
    if ( $u = $sql->fetch_assoc() )
      return password_verify( $password , $u["password"] );
    else return false;
  }

  function update_password( $old_password, $new_password ) {
    global $conn;
    if ( $this->id == 0 ) return false;
    if ( !$this->control_password( $old_password ) ) return false;

    $new_password_hash = password_hash( $new_password, PASSWORD_BCRYPT );
    return $conn->query("UPDATE users SET password = '$new_password_hash' WHERE id = '$this->id'") === TRUE;

  }
}

?>
