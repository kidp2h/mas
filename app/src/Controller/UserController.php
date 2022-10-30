<?php

namespace Controller;

use Application;
use Core\Controller;
use Core\Model;
use Core\Request;
use Core\Response;
use Core\Session;
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
    $this->render('login', [
      'title' => 'Login',
      'titlePage' => 'Memory Album System - 1000 Login',
    ]);
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
        Session::set('user', $user);
        Application::Instance()->setCookie('__masu', base64_encode($user->id));
        Application::Instance()->setCookie(
          '_masu',
          password_hash($user->id . $_ENV['SECRET'], PASSWORD_BCRYPT)
        );
        $response->redirect('/');
      } else {
        $this->render('login', [
          'title' => 'Login',
          'titlePage' => 'Memory Album System - 1000 Login',
          'message' => 'Email or password is incorrect, please try again',
        ]);
      }
    } else {
      $this->render('login', [
        'title' => 'Login',
        'titlePage' => 'Memory Album System - 1000 Login',
        'form' => $result,
      ]);
    }
  }

  public function register(Request $request, Response $response) {
    $this->render('register', [
      'title' => 'Register',
      'titlePage' => 'Memory Album System - 1010 Sign up',
    ]);
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
          'titlePage' => 'Memory Album System - 1010 Sign in',
          'message' => 'Email has already exist, please try again !',
        ]);
      }
    } else {
      $this->render('register', [
        'title' => 'Register',
        'form' => $result,
        'titlePage' => 'Memory Album System - 1010 Sign in',
      ]);
    }
  }
  public static function logout(Request $request, Response $response) {
    Application::Instance()->deleteCookie('_masu');
    Application::Instance()->deleteCookie('__masu');
    $response->redirect('/user/login');
  }
}

?>
