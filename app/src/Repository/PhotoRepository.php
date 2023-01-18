<?php

namespace Repository;

use Core\Repository;
use Model\Photo;

class PhotoRepository extends Repository {
  protected static $nameModel = Photo::class;

  public function upload($data) {
    return $this->model->insert($data);
  }

  public function getPhotoByAttendee($attendeeId, $orgId) {
    return $this->model->select('*')->where('userId', '=', $attendeeId)->where("organizerId", "=", $orgId)->find();
  }
  public function deleteImageByFileName($attendeeId, $fileName) {
    return $this->model->where('attendeeFileName', "=", $fileName)->where('userId', "=", $attendeeId)->delete();
  }
  public function deleteImageById($id) {
    $photo = $this->model->select("*")->where("id", "=", $id)->findOne();
    $photo = (fn ($photo): Photo => $photo)($photo);
    unlink("app/public/resources/uploads/" . $photo->attendeeFileName);
    return $this->model->where('id', '=', $id)->delete();
  }

  public function getAllPhoto() {
    return $this->model->select("*")->find();
  }

  public function getAllPhotoByOrgId($orgId) {
    return $this->model->select("*")->where("organizerId", "=", $orgId)->find();
  }

  public function getPhotoJustUploaded() {
    return $this->model->select("*")->where('ADDTIME(NOW(),"-2")', "<=", "{created_at}")->find();
  }

  public function getPhotoByName($name): ?Photo {
    return $this->model->select("*")->where("attendeeFileName", "=", $name)->findOne();
  }

  public function deleteAllPhoto() {
    return $this->model->where('1', '=', 1)->delete();
  }
  public function likeImageById($id) {
    $photo = $this->model->select("*")->where("id", "=", $id)->findOne();
    $photo = (fn ($photo): Photo => $photo)($photo);
    $likeCount = $photo->likeCount;
    $result = $this->model->where('id', "=", $id)->set("likeCount", $likeCount + 1)->update();
    if ($result['status']) {
      return ['likeCount' => $likeCount + 1, 'status' => true];
    }
    return ['status' => false];
  }
}
