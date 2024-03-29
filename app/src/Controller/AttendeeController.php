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
use Util\Image;
use Validation\AttendeeUploadValidation;

class AttendeeController extends Controller {

  public function __construct() {
  }

  public function toppage(Request $request, Response $response) {
    $id = Application::Instance()->getCookie('room');
    $data = UserRepository::Instance()->getById($id);
    $this->render('toppage', [
      'title' => 'Top page',
      'titlePage' => '思い出アルバム',
      'data' => [
        'eventTitle' => $data->eventTitle,
        'welcomeMessage' => $data->welcomeMessage,
        'welcomeImageFilename' => $data->welcomeImageFilename,
        'name' => $data->name
      ]
    ]);
  }


  public function join(Request $request, Response $response) {
    $id = base64_decode($request->param('id'));

    $org = UserRepository::Instance()->getById($id);
    if (!$org) {
      return $response->redirect('/user/login');
    }
    $userId = Application::Instance()->getCookie("attendee");
    $room = Application::Instance()->getCookie('room');
    if (!$userId || !$room) {
      $randomIdAttendee = abs(crc32(uniqid()));
      Application::Instance()->setCookie("attendee", $randomIdAttendee);
    }
    Application::Instance()->setCookie("room", $org->id);
    return $response->redirect('/attendee/toppage');
  }

  public function upload(Request $request, Response $response) {
    $this->render('upload', [
      'title' => 'Upload',
      'titlePage' => '写真投稿',
    ]);
  }

  public function handleUpload(Request $request, Response $response) {
    header('Access-Control-Allow-Origin: *');
    $body = $request->body();
    $idAttendee = Application::Instance()->getCookie('attendee');

    $validation = new AttendeeUploadValidation();
    $validation->loadData($body);
    $result = $validation->validate();
    if (!is_array($result)) {
      $image = Image::Instance()->upload($body['image']);
      if (!$image->status) {
        return json_encode(['status' => false, "message" => $image?->message]);
      }
      $userId = Application::Instance()->getCookie("attendee");
      $id = Application::Instance()->getCookie("room");
      $data = [
        'attendeeFileName' => $image->name,
        'userId' => $userId,
        'organizerId' => $id,
        'attendeeComment' => $body['message'],
        'attendeeName' => $body['nickname'],
      ];
      $upload = PhotoRepository::Instance()->upload($data);
      EventRepository::Instance()->create([
        "name" => "upload",
        "message" => $image->name,
        "room" => $id,
      ]);
      if ($upload) {
        $response->status(200);
        return json_encode(['status' => true]);
      }
    } else {
      $response->status(400);
      return json_encode($result);
    }
  }

  public function check(Request $request, Response $response) {
    $attendeeId = Application::Instance()->getCookie('attendee');
    $room = Application::Instance()->getCookie("room");
    $orgId = $room;
    $data =  PhotoRepository::Instance()->getAllPhotoByOrgId($orgId);
    $this->render('check', [
      'title' => 'Photo check',
      'titlePage' => '写真投稿',
      'data' => $data ?? [],
      'attendeeId' => $attendeeId ?? null
    ]);
  }

  public function deleteImage(Request $request, Response $response) {
    $attendeeId = Application::Instance()->getCookie('attendee');
    $body = $request->body();
    $result = PhotoRepository::Instance()->deleteImageByFileName($attendeeId, $body['attendeeFileName']);

    $response->status(200);
    return json_encode($result);
  }
  public function likeImage(Request $request, Response $response) {
    $body = $request->body();
    if (isset($body['id'])) {
      $id = $body['id'];
      return json_encode(PhotoRepository::Instance()->likeImageById($id));
    }
    return json_encode(['status' => false]);
  }
}
