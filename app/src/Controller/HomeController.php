<?php

namespace Controller;

use Core\Controller;
use Core\Model;
use Core\Request;
use Core\Response;
use Core\Session;
use DateTime;
use Model\UserModel;
use Repository\UserRepository;

class HomeController extends Controller {


  public function __construct() {
  }


  public function home(Request $request, Response $response) {
    $this->render('home', [
      'title' => 'Photo list',
      'titlePage' => 'Memory Album System - 1100 Photo List',
    ]);
  }
  public function qrcode(Request $request, Response $response) {
    $this->render('qrcode', [
      'title' => 'QR Code',
      'titlePage' => 'Memory Album System - 1300 QR code Print sheet',
    ]);
  }

  public function settings(Request $request, Response $response) {
    $userSession = Session::get(KEY_SESSION_USER);
    $user = UserRepository::Instance()->getById($userSession->id);
    $createdAt = (new DateTime($user->created_at))->format('Y 年 m 月 d 日');
    $this->render('settings', [
      'title' => 'Settings',
      'titlePage' => 'Memory Album System - 1400 Settings',
      'settings' => [
        'name' => $user->name,
        'eventTitle' => $user->eventTitle,
        'welcomeMessage' => $user->welcomeMessage,
        'welcomeMessageFilename' => $user->welcomeImageFilename,
        'created_at' => $createdAt,
        'email' => $user->email,
        'useFlag' => $user->useFlag,
        'actionFlag' => $user->actionFlag,
        'QRCodeFlag' => $user->QRCodeFlag
      ]
    ]);
  }


  public function uploadExhibition(Request $request, Response $response) {
    $this->render('uploadExhibition', [
      'title' => 'Upload Exhibition',
      'titlePage' => 'Memory Album System - 1400 Settings',
    ]);
  }

  public function uploadBase64(Request $request, Response $response) {
    try {
      $body = $request->body();
      $base64Img = $body["image"];
      $ext = "png";
      $file = uniqid() . '.' . $ext;
      $path = 'app/public/resources/uploads/' . $file;
      $status = file_put_contents($path, file_get_contents($base64Img));
      if ($status) {
        return json_encode(["message" => "Uploaded successfully !!", "status" => true]);
      } else {
        return json_encode(["status" => false]);
      }
    } catch (\Throwable $th) {
      echo $th;
    }
  }
}
