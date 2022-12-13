<?php

namespace Middleware;
use Core\Request;
use Core\Response;

class HomeMiddleware {
  public static function pass(Request $request, Response $response) {
    return true;
  }
  public static function fail(Request $request, Response $response) {
    return $response->status(404);
  }
}
?>
