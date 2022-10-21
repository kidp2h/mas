<?php

namespace Middleware;
use Core\Request;
use Core\Response;
use Core\Middleware;

class HomeMiddleware extends Middleware {
  public static function pass(Request $request, Response $response) {
    return true;
  }
  public static function fail(Request $request, Response $response) {
    return $response->status(404);
  }
}
?>
