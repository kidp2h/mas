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
      'titlePage' => 'Memory Album System 2000 Top page',
      'data' => [
        'eventTitle' => $data->eventTitle,
        'welcomeMessage' => $data->welcomeMessage,
        'welcomeImageFilename' => $data->welcomeImageFilename
      ]
    ]);
  }


  public function join(Request $request, Response $response) {
    $id = base64_decode($request->param('id'));
    $userId = Application::Instance()->getCookie("attendee");
    $room = Application::Instance()->getCookie('room');
    if (!$userId || !$room) {
      $randomIdAttendee = abs(crc32(uniqid()));
      Application::Instance()->setCookie("attendee", $randomIdAttendee);
      Application::Instance()->setCookie("room", $id);
    }
    return $response->redirect('/attendee/toppage');
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
    $idAttendee = Application::Instance()->getCookie('attendee');

    $validation = new AttendeeUploadValidation();
    $validation->loadData($body);
    $result = $validation->validate();
    if (!is_array($result)) {
      $image = Image::Instance()->upload($body['image']);
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
    $data =  PhotoRepository::Instance()->getPhotoByAttendee($attendeeId);
    $this->render('check', [
      'title' => 'Photocheck',
      'titlePage' => 'Memory Album System 2000 Top page',
      'data' => $data ?? []
    ]);
  }

  public function deleteImage(Request $request, Response $response) {
    $attendeeId = Application::Instance()->getCookie('attendee');
    $body = $request->body();
    $result = PhotoRepository::Instance()->deleteImageByFileName($attendeeId, $body['attendeeFileName']);
    $response->status(200);
    return json_encode($result);
  }
}
