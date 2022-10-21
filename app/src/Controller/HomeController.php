<?php
namespace Controller;

use Core\Controller;
use Core\Model;
use Core\Request;
use Core\Response;
use Model\UserModel;

class HomeController extends Controller {
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

  public function home(Request $request, Response $response) {
    $this->model->insert([
      'name' => 'Thin123',
      'email' => 'kid2p222h@gmail.com',
      'password' => 'xxx',
    ]);
  }
}
