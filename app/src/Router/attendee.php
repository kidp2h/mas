<?php

use Controller\AttendeeController;
use Core\Request;
use Core\Response;
use Middleware\AttendeeMiddleware;

$app = Application::Instance();
$router = $app->__router;
$router->prefix('attendee');

$router->get(
  '/toppage',
  [[AttendeeMiddleware::class, 'isJoined']],
  fn (
    Request $request,
    Response $response
  ) => AttendeeController::Instance()->toppage($request, $response)
);

$router->get(
  '/upload',
  [[AttendeeMiddleware::class, 'isJoined']],
  fn (
    Request $request,
    Response $response
  ) => AttendeeController::Instance()->upload($request, $response)
);

$router->post(
  '/upload',
  [[AttendeeMiddleware::class, 'isJoined']],
  fn (
    Request $request,
    Response $response
  ) => AttendeeController::Instance()->handleUpload($request, $response)
);

$router->get(
  '/check',
  [[AttendeeMiddleware::class, 'isJoined']],
  fn (
    Request $request,
    Response $response
  ) => AttendeeController::Instance()->check($request, $response)
);

$router->post(
  '/delete-image',
  [[AttendeeMiddleware::class, 'isJoined']],
  fn (
    Request $request,
    Response $response
  ) => AttendeeController::Instance()->deleteImage($request, $response)
);

$router->post(
  '/likeImage',
  [[AttendeeMiddleware::class, 'isJoined']],
  fn (
    Request $request,
    Response $response
  ) => AttendeeController::Instance()->likeImage($request, $response)
);
