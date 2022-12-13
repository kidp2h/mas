<?php

use Controller\AttendeeController;
use Core\Request;
use Core\Response;

$app = Application::Instance();
$router = $app->__router;
$router->prefix('attendee');

$router->get(
  '/toppage',
  [],
  fn (
    Request $request,
    Response $response
  ) => AttendeeController::Instance()->toppage($request, $response)
);

$router->get(
  '/upload',
  [],
  fn (
    Request $request,
    Response $response
  ) => AttendeeController::Instance()->upload($request, $response)
);

$router->post(
  '/upload',
  [],
  fn (
    Request $request,
    Response $response
  ) => AttendeeController::Instance()->handleUpload($request, $response)
);

$router->get(
  '/check',
  [],
  fn (
    Request $request,
    Response $response
  ) => AttendeeController::Instance()->check($request, $response)
);
