<?php

use Core\Request;
use Core\Response;
use Core\Router;

/**
 * Application
 */
class Application {
  private static self $instance;
  public Router $__router;
  private Request $request;
  private Response $response;
  public Session $session;
  public function __construct() {
    Database::Instance()->connect();
    $this->request = new Request();
    $this->response = new Response();

    $this->__router = new Router($this->request, $this->response);
  }

  public static function Instance(): self {
    if (!isset(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function run() {
    $this->route('index');
    $this->route('photo');
    $this->route('user');
    return $this->__router->handle();
  }

  public function setCookie(
    $name,
    $value,
    $time = 60 * 60 * 24 * 30,
    $path = '/'
  ) {
    $time = time() + $time;
    setcookie($name, $value, $time, $path, true, true);
    if ($this->getCookie($name) !== null) {
      return true;
    }
    return false;
  }

  public function getCookie($name) {
    return $_COOKIE[$name];
  }

  public function deleteCookie($name) {
    unset($_COOKIE[$name]);
    $this->setCookie($name, '', time() - 3600);
    return !isset($_COOKIE[$name]);
  }

  public function route(string $filename) {
    require_once __DIR__ . "/../src/Router/{$filename}.php";
  }
}
