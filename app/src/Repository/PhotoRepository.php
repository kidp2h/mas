<?php

namespace Repository;

use Core\Repository;
use Model\Photo;

class PhotoRepository extends Repository {
  protected static $nameModel = Photo::class;

  public function upload($data) {
    return $this->model->insert($data);
  }

  public function getPhotoByAttendee($attendeeId) {
    return $this->model->select('*')->where('userId', '=', $attendeeId)->find();
  }
  public function deleteImageByFileName($attendeeId, $fileName) {
    return $this->model->where('attendeeFileName', "=", $fileName)->where('userId', "=", $attendeeId)->delete();
  }

  public function getAllPhoto() {
    return $this->model->select("*")->find();
  }

  public function getPhotoJustUploaded() {
    return $this->model->select("*")->where('ADDTIME(NOW(),"-2")', "<=", "{created_at}")->find();
  }
}
