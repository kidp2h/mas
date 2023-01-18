<?php

use Controller\AttendeeController;
use Controller\HomeController;
use Controller\UserController;
use Core\Request;
use Core\Response;
use Middleware\AuthMiddleware;
use Middleware\AttendeeMiddleware;

$app = Application::Instance();
$router = $app->__router;
$router->prefix('');

// $router->method(url, [[...middleware]], [callback])
$router->get(
  '/',
  [[AuthMiddleware::class, 'isAuth'], [AuthMiddleware::class, 'isNotExpireTrial']],
  fn (Request $request, Response $response) => HomeController::Instance()->home(
    $request,
    $response
  )
);

$router->get(
  '/qrcode',
  [[AuthMiddleware::class, 'isAuth'], [AuthMiddleware::class, 'isNotExpireTrial']],
  fn (
    Request $request,
    Response $response
  ) => HomeController::Instance()->qrcode($request, $response)
);

$router->get(
  '/settings',
  [[AuthMiddleware::class, 'isAuth'], [AuthMiddleware::class, 'isNotExpireTrial']],
  fn (
    Request $request,
    Response $response
  ) => HomeController::Instance()->settings($request, $response)
);

$router->post(
  "/update-settings",
  [[AuthMiddleware::class, 'isAuth'], [AuthMiddleware::class, 'isNotExpireTrial']],
  fn (
    Request $request,
    Response $response
  ) => UserController::Instance()->updateSettings($request, $response)
);

$router->get(
  '/uploadExhibition',
  [[AuthMiddleware::class, 'isAuth'], [AuthMiddleware::class, 'isNotExpireTrial']],
  fn (
    Request $request,
    Response $response
  ) => HomeController::Instance()->uploadExhibition($request, $response)
);

$router->post('/uploadExhibition', [[AuthMiddleware::class, "isAuth"], [AuthMiddleware::class, 'isNotExpireTrial']], fn (
  Request $request,
  Response $response
) => HomeController::Instance()->uploadBase64($request, $response));

$router->get(
  "/join/{id:.*?[\S\s]+}",
  [],
  fn (
    Request $request,
    Response $response
  ) => AttendeeController::Instance()->join($request, $response)
);

$router->get(
  '/pattern1',
  [[AuthMiddleware::class, "isAuth"], [AuthMiddleware::class, 'isNotExpireTrial']],
  fn (
    Request $request,
    Response $response
  ) => HomeController::Instance()->pattern1($request, $response)
);
$router->get(
  '/pattern2',
  [[AuthMiddleware::class, "isAuth"], [AuthMiddleware::class, 'isNotExpireTrial']],
  fn (
    Request $request,
    Response $response
  ) => HomeController::Instance()->pattern2($request, $response)
);
$router->get(
  '/remote',
  [[AttendeeMiddleware::class, 'isJoined'], [AttendeeMiddleware::class, "isNobodyUsingRemote"]],
  fn (
    Request $request,
    Response $response
  ) => HomeController::Instance()->remote($request, $response)
);
$router->post(
  '/get-images',
  [[AuthMiddleware::class, "isAuth"], [AuthMiddleware::class, 'isNotExpireTrial']],
  fn (
    Request $request,
    Response $response
  ) => HomeController::Instance()->getImages($request, $response)
);

$router->post(
  '/get-new-images',
  [[AuthMiddleware::class, "isAuth"], [AuthMiddleware::class, 'isNotExpireTrial']],
  fn (
    Request $request,
    Response $response
  ) => HomeController::Instance()->getNewImages($request, $response)
);

$router->post(
  '/deleteImage',
  [[AuthMiddleware::class, "isAuth"], [AuthMiddleware::class, 'isNotExpireTrial']],
  fn (
    Request $request,
    Response $response
  ) => HomeController::Instance()->deleteImage($request, $response)
);


$router->post(
  '/remote',
  [[AttendeeMiddleware::class, 'isJoined'], [AttendeeMiddleware::class, "isNobodyUsingRemote"]],
  fn (
    Request $request,
    Response $response
  ) => HomeController::Instance()->handleRemote($request, $response)
);

$router->post(
  '/poll-remote',
  [[AuthMiddleware::class, "isAuth"], [AuthMiddleware::class, 'isNotExpireTrial']],
  fn (
    Request $request,
    Response $response
  ) => HomeController::Instance()->pollRemote($request, $response)
);


$router->post(
  '/downloadAllImage',
  [[AuthMiddleware::class, "isAuth"], [AuthMiddleware::class, 'isNotExpireTrial']],
  fn (
    Request $request,
    Response $response
  ) => HomeController::Instance()->downloadAllImage($request, $response)
);
$router->post(
  '/deleteZipImage',
  [[AuthMiddleware::class, "isAuth"], [AuthMiddleware::class, 'isNotExpireTrial']],
  fn (
    Request $request,
    Response $response
  ) => HomeController::Instance()->deleteZipImage($request, $response)
);
$router->post(
  '/deleteAllImage',
  [[AuthMiddleware::class, "isAuth"], [AuthMiddleware::class, 'isNotExpireTrial']],
  fn (
    Request $request,
    Response $response
  ) => HomeController::Instance()->deleteAllImage($request, $response)
);
