<?php
class Session {
  public static function set($key, $value) {
    $_SESSION[$key] = $value;
    if (!empty($_SESSION[$key])) {
      return true;
    }
    return false;
  }
  public static function get($key) {
    return $_SESSION[$key];
  }
  public static function delete($key = '') {
    if (isset($_SESSION[$key])) {
      unset($_SESSION[$key]);
    }
  }
}
?>
