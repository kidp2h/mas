<?php

use Controller\HomeController;
use Core\Request;
use Core\Response;
use Middleware\HomeMiddleware;

$app = Application::Instance();
$router = $app->__router;
$router->prefix('');

// $router->method(url, [[...middleware]], [callback])
$router->get(
  '/{id:\d+}',
  [
    [HomeMiddleware::class, 'pass'],
    [HomeMiddleware::class, 'pass'],
    [HomeMiddleware::class, 'pass'],
    [HomeMiddleware::class, 'pass'],
  ],
  fn(Request $request, Response $response) => HomeController::Instance()->home(
    $request,
    $response
  )
);
?>
