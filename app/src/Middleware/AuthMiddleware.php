<?php

namespace Middleware;

use Core\Request;
use Core\Response;
use Application;
use Core\Session;
use DateTime;
use Repository\UserRepository;

class AuthMiddleware {
  public static function isAuth(Request $request, Response $response) {
    $user = Application::Instance()->getCookie('__masu');
    $hash = Application::Instance()->getCookie('_masu');

    if (!$user || !$hash) {
      return $response->redirect('/user/login');
    }
    $id = base64_decode(urldecode($user));

    $pwd = $id . $_ENV['SECRET'];

    $isCorrect = password_verify($pwd, urldecode($hash));
    if (!$isCorrect) {
      return $response->redirect('/user/login');
    }
    return true;
  }
  public static function isNotAuth(Request $request, Response $response) {
    $user = Application::Instance()->getCookie('__masu');
    $hash = Application::Instance()->getCookie('_masu');

    if ($user && $hash) {
      $id = base64_decode(urldecode($user));

      $pwd = $id . $_ENV['SECRET'];

      $isCorrect = password_verify($pwd, urldecode($hash));

      if (!$isCorrect) {
        Application::Instance()->deleteCookie('__masu');
        Application::Instance()->deleteCookie('_masu');
        return true;
      } else {
        return $response->redirect('/');
      }
    } else {
      return true;
    }
  }

  public static function isNotExpireTrial(Request $request, Response $response) {
    $masu = Application::Instance()->getCookie("__masu");


    if (!$masu) {
      return $response->redirect('/user/logout');
    }
    $id = base64_decode(urldecode($masu));
    $user = UserRepository::Instance()->getById($id);
    // var_dump($user);
    // var_dump("x");
    // exit;
    if (!$user?->useFlag) {
      Session::setFlash("messageResponse", 'Your trial is expire !');
      return $response->redirect('/user/logout');
    } else {
      if ($user->useFlag === 1) {
        $createdAt = strtotime($user->created_at);
        $now = strtotime((new DateTime())->format('Y-m-d H:i:s'));
        $hours = ($now - $createdAt) / 3600;
        if ($hours >= 48) {
          Session::setFlash("messageResponse", 'Your trial is expire !');
          UserRepository::Instance()->disableById($id);
          return $response->redirect('/user/logout');
        }
      }
      return true;
    }
  }
}
