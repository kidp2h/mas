<?php

namespace Core;

class Response {
  private static self $instance;

  public static function Instance(): self {
    if (!isset(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }
  public function status(int $statusCode) {
    if ($statusCode >= 400 && $statusCode <= 599) {
      http_response_code($statusCode);
      require_once _DIR_ROOT_ . 'src/View/Page/NotFound.php';
    }
    http_response_code($statusCode);
  }

  public function redirect($url) {
    header("Location: $url");
  }
}
