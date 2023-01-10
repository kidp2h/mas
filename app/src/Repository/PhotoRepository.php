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
}
