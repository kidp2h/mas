<?php

namespace Middleware;

use Core\Request;
use Core\Response;
use Application;
use Core\Session;
use DateTime;
use Repository\UserRepository;

class AttendeeMiddleware {
  public static function isJoined(Request $request, Response $response) {
    $room = Application::Instance()->getCookie('room');
    $attendee = Application::Instance()->getCookie('attendee');
    if ($room && $attendee) {
      return true;
    }
    return $response->redirect("/");
  }
}
