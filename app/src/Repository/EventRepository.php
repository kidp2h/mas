<?php

namespace Repository;

use Core\Repository;
use Model\Event;

class EventRepository extends Repository {
  protected static $nameModel = Event::class;

  public function create($data) {
    return $this->model->insert($data);
  }

  public function findAndDelete($room, $name) {
    $event = $this->model->select("*")->where("room", "=", $room)->where("name", "=", $name)->orderBy("created_at", "ASC")->find();
    if (!empty($event)) {
      $this->model->where("room", "=", $room)->where("name", "=", $name)->delete();
      return $event;
    }
  }
}
