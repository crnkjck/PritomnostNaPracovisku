<?php

class User {
  var $id = 0;
  var $personal_id = 0;
  var $status = 0;
  var $username = "";
  var $name = "";
  var $surname = "";
  var $title = "";
  var $email = "";
  var $last_login = "";
  var $user = false, $super_user = false, $admin = false;

  function __construct( $personal_id = 0, $username = "", $password_hash = ""  ){
    if ( isset( $_GET['logout'] ) ) $this->logout();
    if ( $personal_id == 0 ) $this->login( $username, $password_hash );
    else $this->get_user( $personal_id );
  }

  function logout() {
    session_unset();
    session_destroy();
    header('Location: index.php');
  }

  static function check_login() {
    if ( isset( $_POST['login_username'] ) and isset( $_POST['login_password'] ) ) {
      $u = new User( 0, $_POST['login_username'], md5($_POST['login_password']) );
      $_SESSION['personal_id'] = $u->personal_id;
      if ( $u->personal_id > 0 ) header('Location: index.php');;
      return $u;
    }
    if ( isset( $_SESSION['personal_id'] ) ) {
      return new User( $_SESSION['personal_id'] );
    }
    else return new User();
  }

  function login( $username, $password_hash ) {
    global $conn;
    $u = $conn->query("SELECT * FROM users WHERE username = '$username' AND password = '$password_hash' AND status != 0");
    $this->load_data( $u );
  }

  function get_user( $personal_id ) {
    global $conn;
    $u = $conn->query("SELECT * FROM users WHERE personal_id = '$personal_id'");
    $this->load_data( $u );
  }

  function load_data( $user ){
    if ( $u = $user->fetch_assoc() ) {
      $this->username = $u['username'];
      $this->name = $u['name'];
      $this->surname = $u['surname'];
      $this->title = $u['title'];
      $this->email = $u['email'];
      $this->id = $u['id'];
      $this->personal_id = $u['personal_id'];
      $this->status = $u['status'];
      $this->last_login = $u['last_login'];
    }

    if ( $this->status > 0 ) $this->user = true;
    if ( $this->status == 2 ) $this->super_user = true;
    if ( $this->status == 3 ) $this->admin = true;
  }

  function update() {
    global $conn;
    if ( $this->id == 0 ) return false;
    return $conn->query("UPDATE users SET
      username = '$this->username', name = '$this->name', surname = '$this->surname',
      title = '$this->title', email = '$this->email', personal_id = '$this->personal_id',
      status = '$this->status' WHERE id = $this->id") === TRUE;
  }

  function update_password( $old_password_hash, $new_password_hash ) {
    global $conn;
    if ( $this->id == 0 ) return false;
    return $conn->query("UPDATE users SET password = '$new_password_hash' WHERE id = $this->id
      AND password = '$old_password_hash'") === TRUE;
  }

  function update_last_login() {
    global $conn;
    if ( $this->id == 0 ) return false;
    return $conn->query("UPDATE users SET last_login = NOW() WHERE id = $this->id") === TRUE;
  }

  function get_full_name( $x = 0 ) {
    if ($x == 0) return "$this->name $this->surname";
    else return "$this->surname $this->name";
  }

  static function create_all_users() {
    global $conn;

    $arr = [];
    $users = $conn->query("SELECT id, personal_id FROM users ORDER BY surname, name");
    while ( $u = $users->fetch_assoc() ) $arr[$u['id']] = new User($u['personal_id']);
    return $arr;
  }
}

?>
