<?php

namespace Controller;

use Core\Controller;
use Core\Model;
use Core\Request;
use Core\Response;
use Core\Template;
use Model\UserModel;

class UserController extends Controller {
  private Model $model;

  private static self $instance;

  public function __construct() {
    $this->model = new UserModel();
  }

  public static function Instance(): self {
    if (!isset(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function login(Request $request, Response $response) {
    $this->render("login", ["title" => "Login"]);
  }

  public function handleLogin(Request $request, Response $response) {
  }

  public function register(Request $request, Response $response) {
    $this->render("register", ["title" => "Register"]);
  }

  public function handleRegister(Request $request, Response $response) {
    $body = $request->body();
    echo '<pre>';
    var_dump($body);
    echo '</pre>';
  }
}

?>
