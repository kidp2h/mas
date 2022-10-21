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
    return $this->__router->handle();
  }

  public function route(string $filename) {
    require_once __DIR__ . "/../src/Router/{$filename}.php";
  }
}
