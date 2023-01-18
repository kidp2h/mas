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
use Repository\EventRepository;
use Repository\PhotoRepository;
use Repository\UserRepository;
use ZipArchive;

class HomeController extends Controller {


  public function __construct() {
  }


  public function home(Request $request, Response $response) {
    $__masu = Application::Instance()->getCookie("__masu");
    $orgId = base64_decode(urldecode($__masu));
    $listPhotos = PhotoRepository::Instance()->getAllPhotoByOrgId($orgId);
    $user = UserRepository::Instance()->getById($orgId);
    $this->render('home', [
      'title' => '思い出アルバム',
      'titlePage' => '写真リスト',
      'photos' => $listPhotos ?? [],
      'pattern' => $user?->actionFlag
    ]);
  }
  public function qrcode(Request $request, Response $response) {
    $__masu = Application::Instance()->getCookie("__masu");
    $orgId = base64_decode(urldecode($__masu));
    $user = UserRepository::Instance()->getById($orgId);
    $this->render('qrcode', [
      'title' => 'QR Code',
      'titlePage' => 'QRコード印刷シート',
      'name' => $user?->name,
      'eventTitle' => $user?->eventTitle,
      'welcomeMessage' => $user?->welcomeMessage,
      'welcomeMessageFilename' => $user?->welcomeImageFilename,
      'email' => $user?->email,
      'useFlag' => $user?->useFlag,
      'actionFlag' => $user?->actionFlag,
      'QRCodeFlag' => $user?->QRCodeFlag
    ]);
  }

  public function settings(Request $request, Response $response) {
    $__masu = Application::Instance()->getCookie("__masu");
    $orgId = base64_decode(urldecode($__masu));
    $user = UserRepository::Instance()->getById($orgId);
    $createdAt = (new DateTime($user->created_at))->format('Y 年 m 月 d 日');
    $this->render('settings', [
      'title' => 'Settings',
      'titlePage' => '設　定',
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
      'titlePage' => '設　定',
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
        $__masu = Application::Instance()->getCookie("__masu");
        $orgId = base64_decode(urldecode($__masu));
        PhotoRepository::Instance()->upload([
          "attendeeFileName" => $file,
          "organizerId" => $orgId,
          'attendeeComment' => "",
          'attendeeName' => "organizer",
          'userId' => $orgId
        ]);
        return json_encode(["message" => "Uploaded successfully !!", "status" => true]);
      } else {
        return json_encode(["status" => false]);
      }
    } catch (\Throwable $th) {
      echo $th;
    }
  }

  public function pattern1(Request $request, Response $response) {
    $__masu = Application::Instance()->getCookie("__masu");
    $orgId = base64_decode(urldecode($__masu));
    $user = UserRepository::Instance()->getById($orgId);
    $listPhotos = PhotoRepository::Instance()->getAllPhotoByOrgId($orgId);
    $this->render('pattern1', [
      'title' => 'Exhibition',
      'titlePage' => $user?->eventTitle,
      'photos' => $listPhotos ?? []
    ]);
  }
  public function pattern2(Request $request, Response $response) {
    $__masu = Application::Instance()->getCookie("__masu");
    $orgId = base64_decode(urldecode($__masu));
    $user = UserRepository::Instance()->getById($orgId);
    $listPhotos = PhotoRepository::Instance()->getAllPhotoByOrgId($orgId);
    $this->render('pattern2', [
      'title' => 'Exhibition',
      'titlePage' => $user?->eventTitle,
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
  public function getNewImages(Request $request, Response $response) {
    $__masu = Application::Instance()->getCookie("__masu");
    $orgId = base64_decode(urldecode($__masu));
    $events = EventRepository::Instance()->findAndDelete($orgId, "upload");
    $data = [];
    if ($events) {
      foreach ($events as $value) {
        $photo =  PhotoRepository::Instance()->getPhotoByName($value->message);
        array_push($data, [
          "id" => $photo->id,
          "userId" => $photo->userId,
          "organizerId" => $photo->organizerId,
          "attendeeFileName" => $photo->attendeeFileName,
          "attendeeName" => $photo->attendeeName,
          "attendeeComment" => $photo->attendeeComment
        ]);
      }
      return json_encode(["status" => true, 'data' => $data]);
    } else {
      return json_encode(["status" => false, "data" => null]);
    }
  }

  public function deleteImage(Request $request, Response $response) {
    $body = $request->body();

    if (isset($body['id'])) {
      $id = $body['id'];
      return json_encode(PhotoRepository::Instance()->deleteImageById($id));
    }
  }
  public function remote(Request $request, Response $response) {
    $attendeeId = Application::Instance()->getCookie('attendee');
    $room = Application::Instance()->getCookie("room");
    $result = EventRepository::Instance()->upsert($room, 'use-remote', $attendeeId);
    $this->render('remote', ["titlePage" => "パネルリモコン", "title" => "Remote", "status" => $result['status']]);
  }

  public function handleRemote(Request $request, Response $response) {
    $body = $request->body();
    $action = $body['action'];
    $attendeeId = Application::Instance()->getCookie('attendee');
    $room = Application::Instance()->getCookie("room");
    EventRepository::Instance()->updateTimeEvent($room, $attendeeId);
    EventRepository::Instance()->create([
      'name' => "remote",
      'message' => $action,
      'room' => $room
    ]);
    return json_encode(['status' => true]);
  }

  public function pollRemote(Request $request, Response $response) {
    $__masu = Application::Instance()->getCookie("__masu");
    $orgId = base64_decode(urldecode($__masu));
    $events = EventRepository::Instance()->findAndDelete($orgId, "remote");
    if ($events) {
      return json_encode(["status" => true, 'data' => $events]);
    } else {
      return json_encode(["status" => false, "data" => null]);
    }
  }
  public function downloadAllImage(Request $request, Response $response) {
    $__masu = Application::Instance()->getCookie("__masu");
    $orgId = base64_decode(urldecode($__masu));
    $zip = new ZipArchive();
    $listImages = PhotoRepository::Instance()->getAllPhotoByOrgId($orgId);
    if (!$listImages || empty($listImages)) {
      return json_encode(["status" => false]);
    }
    $zipName = md5(rand(0, time())) . ".zip";
    if ($zip->open("app/public/resources/uploads/" . $zipName, ZIPARCHIVE::CREATE) === TRUE) {
      foreach ($listImages as $value) {
        $zip->addFile("app/public/resources/uploads/" . $value->attendeeFileName, $value->attendeeFileName);
      }
      // close and save archive
      $zip->close();
      $url = $_ENV['BASE_URL'] . "/resources/uploads/" . $zipName;
      return json_encode(["status" => true, "url" => $url, "name" => $zipName]);
    }
    return json_encode(["status" => false]);
  }
  public function deleteAllImage(Request $request, Response $response) {

    return json_encode(PhotoRepository::Instance()->deleteAllPhoto());
  }
  public function deleteZipImage(Request $request, Response $response) {
    $body = $request->body();
    if (isset($body['name'])) {
      $filePath = "app/public/resources/uploads/" . $body['name'];
      if (file_exists($filePath)) {
        $result = unlink($filePath);

        if ($result) return json_encode(["status" => true]);
      }
    }
    return json_encode(["status" => false]);
  }
}
