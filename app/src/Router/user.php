<?php

use Controller\UserController;
use Core\Request;
use Core\Response;
use Middleware\AuthMiddleware;

$app = Application::Instance();
$router = $app->__router;
$router->prefix('user');

$router->get(
  '/register',
  [[AuthMiddleware::class, 'isNotAuth']],
  fn (
    Request $request,
    Response $response
  ) => UserController::Instance()->register($request, $response)
);

$router->get(
  '/login',
  [[AuthMiddleware::class, 'isNotAuth']],
  fn (Request $request, Response $response) => UserController::Instance()->login(
    $request,
    $response
  )
);

$router->post(
  '/register',
  [[AuthMiddleware::class, 'isNotAuth']],
  fn (
    Request $request,
    Response $response
  ) => UserController::Instance()->handleRegister($request, $response)
);

$router->post(
  '/login',
  [[AuthMiddleware::class, 'isNotAuth']],
  fn (
    Request $request,
    Response $response
  ) => UserController::Instance()->handleLogin($request, $response)
);

$router->get('/reset-password/{token:.*?[\S\s]+}', [[AuthMiddleware::class, 'isNotAuth']], fn (
  Request $request,
  Response $response
) => UserController::Instance()->reset($request, $response));
$router->get('/forgot-password', [[AuthMiddleware::class, 'isNotAuth']], fn (
  Request $request,
  Response $response
) => UserController::Instance()->forgot($request, $response));

$router->post('/reset-password/{token:.*?[\S\s]+}', [[AuthMiddleware::class, 'isNotAuth']], fn (
  Request $request,
  Response $response
) => UserController::Instance()->handleReset($request, $response));
$router->post('/forgot-password', [[AuthMiddleware::class, 'isNotAuth']], fn (
  Request $request,
  Response $response
) => UserController::Instance()->handleForgot($request, $response));
$router->get('/logout', [], [UserController::class, 'logout']);

// $router->post(
//   '/reset-password',
//   [[AuthMiddleware::class, 'isNotAuth']],
//   [UserController::class, 'handleResetPassword']
// );


// $router->post(
//   '/forgot-password',
//   [[AuthMiddleware::class, 'isNotAuth']],
//   [UserController::class, 'handleResetPassword']
// );
