<?php

use Controller\HomeController;
use Core\Request;
use Core\Response;
use Middleware\AuthMiddleware;

$app = Application::Instance();
$router = $app->__router;
$router->prefix('');

// $router->method(url, [[...middleware]], [callback])
$router->get(
  '/',
  [[AuthMiddleware::class, 'isAuth']],
  fn(Request $request, Response $response) => HomeController::Instance()->home(
    $request,
    $response
  )
);

$router->get(
  '/qrcode',
  [[AuthMiddleware::class, 'isAuth']],
  fn(
    Request $request,
    Response $response
  ) => HomeController::Instance()->qrcode($request, $response)
);

$router->get(
  '/settings',
  [[AuthMiddleware::class, 'isAuth']],
  fn(
    Request $request,
    Response $response
  ) => HomeController::Instance()->settings($request, $response)
);
?>
