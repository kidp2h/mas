<?php

namespace Controller;

use Application;
use Core\Controller;
use Core\Model;
use Core\Request;
use Core\Response;
use Core\Session;
use DateTime;
use Model\UserModel;
use Validation\AttendeeUploadValidation;

class AttendeeController extends Controller {

  public function __construct() {
  }

  public function toppage(Request $request, Response $response) {
    $this->render('toppage', [
      'title' => 'Top page',
      'titlePage' => 'Memory Album System 2000 Top page',
    ]);
  }

  public function upload(Request $request, Response $response) {
    $this->render('upload', [
      'title' => 'Upload',
      'titlePage' => 'Memory Album System 2000 Top page',
    ]);
  }

  public function handleUpload(Request $request, Response $response) {
    header('Access-Control-Allow-Origin: *');
    $body = $request->body();
    $validation = new AttendeeUploadValidation();
    $validation->loadData($body);
    $result = $validation->validate();
    $validSize = 3000000;
    $_result = (object)[];
    if (!is_array($result)) {
      $image = $body['image'];
      $payloadFile = explode(".", $image["name"]);
      if (!empty($payloadFile)) {
        $name = str_replace(' ', '-', $payloadFile[0]) . time();
        $ext = $payloadFile[1];

        $validExt = ["jpg", "jpeg", "png"];

        if (in_array($ext, $validExt) && $_FILES["image"]["size"] < $validSize && !$_FILES["image"]["error"]) {
          $path = "app/public/resources/uploads/" . $name . ".$ext";

          $flag = move_uploaded_file($_FILES["image"]["tmp_name"], $path);

          if ($flag) {

            $_result->image = $_ENV['BASE_URL'] . "/resources/uploads/$name.$ext";
            $_result->size = number_format($_FILES["image"]["size"] / 1024 / 1024, 2) . " MB";
            $_result->name = "$name.$ext";
            $_result->status = true;
            $response->status(200);
            return json_encode($_result);
          }
        } else if ($_FILES["image"]["size"] > $validSize) {
          $_result->status = false;
          $_result->error = "File size too large !!";
          $response->status(400);
          return json_encode($_result);
        } else {
          $_result->status = false;
          $_result->error = "Invalid extension file";
          $response->status(400);
          return json_encode($_result);
        }
      } else {
        $_result->status = false;
        $_result->error = "Invalid  file";
        $response->status(400);
        return json_encode($_result);
      }
    } else {
      $response->status(400);
      return json_encode($result);
    }
  }

  public function check(Request $request, Response $response) {
    $this->render('check', [
      'title' => 'Photocheck',
      'titlePage' => 'Memory Album System 2000 Top page',
    ]);
  }
}
