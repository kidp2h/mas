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
    $userSession = Session::get(KEY_SESSION_USER);
    if (!$userSession) {
      return $response->redirect('/user/logout');
    }
    $user = UserRepository::Instance()->getById($userSession->id);
    if ($user?->useFlag) {
      $createdAt = strtotime($user->created_at);
      $now = strtotime((new DateTime())->format('Y-m-d H:i:s'));
      $hours = ($now - $createdAt) / 3600;
      if ($hours > 1) {
        Session::setFlash("messageResponse", 'Your trial is expire !');
        return $response->redirect('/user/logout');
      }
    }
    return true;
  }
}
