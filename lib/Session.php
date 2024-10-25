<?php

// Clase Session

class Session
{


  // Método inicio de sesión
  public static function init()
  {

    if (version_compare(phpversion(), '5.4.0', '<')) {
      if (session_id() == '') {
        session_start();
      }
    } else {
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
    }
  }


  // Método set
  public static function set($key, $val)
  {
    $_SESSION[$key] = $val;
  }



  // Método get
  public static function get($key)
  {
    if (isset($_SESSION[$key])) {
      return $_SESSION[$key];
    } else {
      return false;
    }
  }

  // Método logout
  public static function destroy()
  {
    session_destroy();
    session_unset();
    echo "<script>window.location='login.php';</script>";
  }


  // Método de verificación de sesión
  public static function CheckSession()
  {
    if (self::get('login') == FALSE) {
      session_destroy();
      echo "<script>window.location='login.php';</script>";
    }
  }


  // Método de verificación de logueo
  public static function CheckLogin()
  {
    if (self::get("login") == TRUE) {
      echo "<script>window.location='index.php';</script>";
    }
  }
}
