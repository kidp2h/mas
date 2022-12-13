<?php

namespace Model;

use Core\Model;
use DateTime;

class User extends Model {
  public static string $nameTable = 'users';
  public int $id;
  public string $name;
  public string $email;
  public string $password;
  public ?string $eventTitle;
  public ?string $welcomeMessage;
  public ?string $welcomeImageFilename;
  public int $actionFlag;
  public int $QRCodeFlag;
  public ?string $memo;
  public int $useFlag;
  public DateTime|string $created_at;
  public DateTime|string $updated_at;
}
