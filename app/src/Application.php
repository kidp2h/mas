<?php

use Core\Request;
use Core\Response;
use Core\Router;
use Core\Session;
use Core\SingletonBase;
use Repository\UserRepository;

/**
 * application
 */
class Application extends SingletonBase {
  public Router $__router;
  private Request $request;
  private Response $response;
  public function __construct() {
    Database::Instance()->connect();
    $this->request = new Request();
    $this->response = new Response();
    $user = $this->getCookie('__masu');
    $userSession = Session::get(KEY_SESSION_USER);
    if ($user && empty($userSession)) {
      $userObject = UserRepository::Instance()->getById(base64_decode($user));
      Session::set(KEY_SESSION_USER, $userObject);
    }
    $hash = $this->getCookie('_masu');
    if ($user && empty(Session::get('user'))) {
      $id = base64_decode(urldecode($user));
      $isCorrect = password_verify($id . $_ENV['SECRET'], urldecode($hash));
      if ($isCorrect) {
        Session::set('user', $user);
      }
    }

    $this->__router = new Router($this->request, $this->response);
  }


  public function run() {
    $this->route('index');
    $this->route('photo');
    $this->route('user');
    $this->route('attendee');
    echo $this->__router->handle();
  }

  public function setCookie(
    $name,
    $value,
    $time = 60 * 60 * 24 * 30,
    $path = '/'
  ) {
    $time = time() + $time;
    setcookie($name, $value, $time, $path, '', true, true);
    if ($this->getCookie($name) !== null) {
      return true;
    }
    return false;
  }

  public function getCookie($name) {
    if (isset($_COOKIE[$name])) {
      return $_COOKIE[$name];
    }
    return null;
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
