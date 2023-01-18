<?php

namespace Model;

use Core\Model;


class Event extends Model {
  public static string $nameTable = 'events';
  public int $id;
  public string $name;
  public string $message;
  public string $room;
  public string $created_at;
  public string $updated_at;
}
