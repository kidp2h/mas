<?php

use Controller\HomeController;
use Core\Request;
use Core\Response;

$app = Application::Instance();

$router = $app->__router;
$router->prefix('photo');

// $router->method(url, [...middleware], [callback])
$router->get(
  '/{id:\d+}',

  fn(Request $request, Response $response) => HomeController::Instance()->home(
    $request,
    $response
  )
);
?>
