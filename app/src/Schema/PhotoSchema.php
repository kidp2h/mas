<?php

namespace Schema;
use Core\Schema;

class PhotoSchema extends Schema {
  public int $id;
  public string $attendeeFileName;
  public string $attendeeName;
  public string $attendeeComment;
  public int $useFlag;
  public \DateTime $created_at;
  public int $created_by;
}
?>
