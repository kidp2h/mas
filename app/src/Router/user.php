<?php
use Controller\UserController;
use Core\Request;
use Core\Response;
use Middleware\HomeMiddleware;

$app = Application::Instance();
$router = $app->__router;
$router->prefix('user');

$router->get(
  '/register',
  [],
  fn(
    Request $request,
    Response $response
  ) => UserController::Instance()->register($request, $response)
);

$router->get(
  '/login',
  [],
  fn(Request $request, Response $response) => UserController::Instance()->login(
    $request,
    $response
  )
);

$router->post(
  '/register',
  [],
  fn(
    Request $request,
    Response $response
  ) => UserController::Instance()->handleRegister($request, $response)
);

$router->post(
  '/login',
  [],
  fn(
    Request $request,
    Response $response
  ) => UserController::Instance()->handleLogin($request, $response)
);

?>
