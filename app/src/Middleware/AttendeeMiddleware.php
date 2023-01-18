<?php

namespace Middleware;

use Core\Request;
use Core\Response;
use Application;
use Core\Session;
use DateTime;
use Repository\EventRepository;

class AttendeeMiddleware {
  public static function isJoined(Request $request, Response $response) {
    $room = Application::Instance()->getCookie('room');
    $attendee = Application::Instance()->getCookie('attendee');
    if ($room && $attendee) {
      return true;
    }
    return $response->redirect("/");
  }
  public static function isNobodyUsingRemote(Request $request, Response $response) {
    $event = EventRepository::Instance()->getEventByName('use-remote');
    $attendee = Application::Instance()->getCookie('attendee');
    if ($event && $event->message !== $attendee) return $response->redirect("/attendee/toppage");
    return true;
  }
}
