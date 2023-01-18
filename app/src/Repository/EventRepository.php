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

  public function upsert($room, $name, $message = "") {
    $event = $this->model->select("*")->where("room", "=", $room)->where("name", "=", $name)->findOne();
    if (!$event) {
      $result = $this->model->insert([
        "name" => $name,
        "message" => $message,
        "room" => $room
      ]);
      return ["status" => $result];
    }

    return ["status" => false, "message" => "Someone is using remote"];
  }

  public function getEventByName($name): ?Event {
    return $this->model->select("*")->where("name", "=", $name)->findOne();
  }

  public function updateTimeEvent($room, $name) {
    return $this->model->where("room", "=", $room)->where("name", "=", $name)->set("updated_at", "NOW()")->update();
  }
}
