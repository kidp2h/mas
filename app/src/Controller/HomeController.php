<?php

namespace Controller;

use Core\Controller;
use Core\Model;
use Core\Request;
use Core\Response;
use Core\Session;
use DateTime;
use Model\UserModel;
use Repository\PhotoRepository;
use Repository\UserRepository;

class HomeController extends Controller {


  public function __construct() {
  }


  public function home(Request $request, Response $response) {
    $listPhotos = PhotoRepository::Instance()->getAllPhoto();
    $this->render('home', [
      'title' => 'Photo list',
      'titlePage' => 'Memory Album System - 1100 Photo List',
      'photos' => $listPhotos ?? []
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
        'name' => $user?->name,
        'eventTitle' => $user?->eventTitle,
        'welcomeMessage' => $user?->welcomeMessage,
        'welcomeMessageFilename' => $user?->welcomeImageFilename,
        'created_at' => $createdAt,
        'email' => $user?->email,
        'useFlag' => $user?->useFlag,
        'actionFlag' => $user?->actionFlag,
        'QRCodeFlag' => $user?->QRCodeFlag
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

  public function pattern1(Request $request, Response $response) {
    $listPhotos = PhotoRepository::Instance()->getAllPhoto();
    $this->render('pattern1', [
      'title' => 'Exhibition',
      'titlePage' => 'Memory Album System - 1200 Exhibition panel (Pattern 1)',
      'photos' => $listPhotos ?? []
    ]);
  }
  public function pattern2(Request $request, Response $response) {
    $listPhotos = PhotoRepository::Instance()->getAllPhoto();
    $this->render('pattern2', [
      'title' => 'Exhibition',
      'titlePage' => 'Memory Album System - 1200 Exhibition panel (Pattern 2)',
      'photos' => $listPhotos ?? []
    ]);
  }

  public function getImages(Request $request, Response $response) {
    $photo = PhotoRepository::Instance()->getPhotoJustUploaded();
    $data = [];
    if ($photo) {
      foreach ($photo as $key => $value) {
        array_push($data, [
          "id" => $value->id,
          "userId" => $value->userId,
          "organizerId" => $value->organizerId,
          "attendeeFileName" => $value->attendeeFileName,
          "attendeeName" => $value->attendeeName,
          "attendeeComment" => $value->attendeeComment
        ]);
      }
    } else {
      return json_encode(["status" => false, "data" => null]);
    }
    return json_encode(["status" => true, 'data' => $data]);
  }
}
