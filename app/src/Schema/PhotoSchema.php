<?php

namespace Schema;
use Core\Schema;

class PhotoSchema extends Schema {
  public int $id;
  public int $userId;
  public string $attendeeFileName;
  public string $attendeeName;
  public string $attendeeComment;
  public int $useFlag;
}
?>
