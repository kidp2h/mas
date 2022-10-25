<?php

namespace Controller;

use Core\Controller;
use Core\Model;
use Core\Request;
use Core\Response;
use Core\Template;
use Model\UserModel;
use Validation\LoginValidation;
use Validation\RegistrationValidation;

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
    $this->render('login', ['title' => 'Login']);
  }

  public function handleLogin(Request $request, Response $response) {
    $body = $request->body();
    $validation = new LoginValidation();
    $validation->loadData($body);
    $result = $validation->validate();
    if ($result === true) {
      $rows = $this->model
        ->select('*')
        ->where('email', '=', $body['email'])
        ->where('password', '=', md5($body['password']))
        ->get();
      if (!empty($rows)) {
        $user = $rows[0];
        $response->redirect('/');
      } else {
        $this->render('login', [
          'title' => 'Login',
          'message' => 'Email or password is incorrect, please try again',
        ]);
      }
    }
  }

  public function register(Request $request, Response $response) {
    $this->render('register', ['title' => 'Register']);
  }

  public function handleRegister(Request $request, Response $response) {
    $body = $request->body();

    $validation = new RegistrationValidation();
    $validation->loadData($body);
    $result = $validation->validate();
    if ($result === true) {
      $isInsert = UserModel::Instance()->insert($body);
      if ($isInsert) {
        $response->redirect('/user/login');
      } else {
        $this->render('register', [
          'title' => 'Register',
          'message' => 'Email has already exist, please try again !',
        ]);
      }
    } else {
      $this->render('register', ['title' => 'Register', 'form' => $result]);
    }
  }
  public function logout(Request $request, Response $response) {
  }
}

?>
