<?php

namespace Controller;

use Application;
use Core\Controller;
use Core\Model;
use Core\Request;
use Core\Response;
use Core\Session;
use DateTime;
use Repository\UserRepository;
use Util\Image;
use Util\Token;
use Validation\LoginValidation;
use Validation\RegistrationValidation;
use Validation\UpdateSettingsValidation;

class UserController extends Controller {
  private readonly UserRepository $userRepository;
  public function __construct() {
    $this->userRepository = UserRepository::Instance();
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
      $row = $this->userRepository->checkUser($body['email'], $body["password"]);
      if (!empty($row)) {
        if ($row->useFlag) {
          $createdAt = strtotime($row->created_at);
          $now = strtotime((new DateTime())->format('Y-m-d H:i:s'));
          $hours = ($now - $createdAt) / 3600;
          if ($hours > 1) {
            return $this->render('login', [
              'title' => 'Login',
              'titlePage' => 'Memory Album System - 1000 Login',
              'message' => 'Your trial is expire !!',
            ]);
          }
        }
        Session::set('user', $row);
        Application::Instance()->setCookie('__masu', base64_encode($row->id));
        Application::Instance()->setCookie(
          '_masu',
          password_hash($row->id . $_ENV['SECRET'], PASSWORD_BCRYPT)
        );
        $response->redirect('/');
      } else {
        $this->render('login', [
          'title' => 'Login',
          'titlePage' => 'Memory Album System - 1000 Login',
          'message' => 'Email or password is incorrect !',
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
      $isInsert = $this->userRepository->register($body);
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

  public function forgot(Request $request, Response $response) {
    $this->render('forgot', [
      'title' => 'Forgot password',
      'titlePage' => 'Memory Album System - 1020 Forgot password',
    ]);
  }

  public function handleForgot(Request $request, Response $response) {
    $body = $request->body();
    $email = $body["email"];
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      try {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: $email" . "\r\n";
        $user = $this->userRepository->getByEmail($email);
        if (!empty($user)) {
          $token = Token::Instance()->generateTokenReset($user->id);
          $htmlContent = "
          Hi $email. <br>
          There was a request to change your password!<br>
          <br>
          If you did not make this request then please ignore this email.<br>
          <br>
          Otherwise, please click this link to change your password: <a href='http://localhost/user/reset-password/$token'>Click here</a>
          ";
          mail($email, "Reset password", $htmlContent, $headers);
          $response->redirect("/user/login");
        } else {
          $this->render('forgot', [
            'title' => 'Forgot password',
            'titlePage' => 'Memory Album System - 1020 Forgot password',
            "errorEmail" => "Email is not exist !!"
          ]);
        }
      } catch (\Throwable $th) {
        echo $th;
      }
    } else {
      $this->render('forgot', [
        'title' => 'Forgot password',
        'titlePage' => 'Memory Album System - 1020 Forgot password',
        "errorEmail" => "Email is invalid"
      ]);
    }
  }

  public function reset(Request $request, Response $response) {
    $token = $request->param("token");
    $result = Token::Instance()->verfiy($token);
    if (!$result["status"])
      return $response->redirect("/user/forgot-password");
    $this->render('reset', [
      'title' => 'Reset password',
      'titlePage' => 'Memory Album System - 1030 Reset password',
    ]);
  }

  public function handleReset(Request $request, Response $response) {
    $body = $request->body();
    $password = $body['password'];
    $confirm = $body['confirm'];
    $token = $request->param("token");
    $result = Token::Instance()->generatePayload($token);
    if (!$result["status"])
      return $response->redirect("/user/forgot-password");
    // update password
    $resultUpdate = $this->userRepository->resetPassword($result["payload"], $password);
    if (!$resultUpdate["status"]) return $response->status(400);
    return $response->redirect("/user/login");
  }
  public static function logout(Request $request, Response $response) {
    Application::Instance()->deleteCookie('_masu');
    Application::Instance()->deleteCookie('__masu');
    $response->redirect('/user/login');
  }

  public function updateSettings(Request $request, Response $response) {
    try {
      $id = base64_decode(Application::Instance()->getCookie('__masu'));
      $data = $request->body();
      $validation = new UpdateSettingsValidation();
      $validation->loadData($data);
      $result = $validation->validate();
      if (!is_array($result)) {
        if (isset($data['image'])) {
          $imageResult = Image::Instance()->upload($data['image']);
          $data['image'] = $imageResult;
        }

        $statusUpdate = $this->userRepository->updateSettings($data, $id);
        $response->status(200);
        return json_encode($statusUpdate);
      } else {
        $response->status(400);
        return json_encode($result);
      }
    } catch (\Throwable $th) {
      echo $th;
    }
  }
}
