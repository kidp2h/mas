<?php

namespace Schema;

use Core\Schema;

class UserSchema extends Schema {
  public int $id;
  public string $name;
  public string $email;
  public string $password;
  public string $eventTitle;
  public string $welcomeMessage;
  public string $welcomeImageFilename;
  public int $actionFlag;
  public int $QRCodeFlag;
  public string $memo;
  public int $useFlag;
  public \DateTime $created_at;
  public int $created_by;
  public \DateTime $updated_at;
  public int $updated_by;
}
?>
