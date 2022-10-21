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
    // $this->model
    //   ->select('id', 'name', 'email')
    //   ->where('name', '>', '5')
    //   ->where('id', '=', '5')
    //   ->orWhere(function ($query) {
    //     $query->where('email', '>', '5');
    //     $query->where('email', '<', '10');
    //   })
    //   ->where('name', '<', '11')
    //   ->get();
    $this->model->insert([
      'name' => 'Thinh',
      'email' => 'kidp2h@gmail.com',
      'password' => 'xxxx',
    ]);
  }
}
