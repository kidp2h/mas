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
  fn(
    Request $request,
    Response $response
  ) => UserController::Instance()->register($request, $response)
);

$router->get(
  '/login',
  [[AuthMiddleware::class, 'isNotAuth']],
  fn(Request $request, Response $response) => UserController::Instance()->login(
    $request,
    $response
  )
);

$router->post(
  '/register',
  [[AuthMiddleware::class, 'isNotAuth']],
  fn(
    Request $request,
    Response $response
  ) => UserController::Instance()->handleRegister($request, $response)
);

$router->post(
  '/login',
  [[AuthMiddleware::class, 'isNotAuth']],
  fn(
    Request $request,
    Response $response
  ) => UserController::Instance()->handleLogin($request, $response)
);

$router->get('/reset-password', [], [UserController::class, 'resetPassword']);
$router->get('/logout', [], [UserController::class, 'logout']);

$router->post(
  '/reset-password',
  [[AuthMiddleware::class, 'isNotAuth']],
  [UserController::class, 'handleResetPassword']
);

?>
