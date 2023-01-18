<?php

namespace Model;

use Core\Model;
use DateTime;

class Photo extends Model {
  public static string $nameTable = 'photos';
  public int $id;
  public int $userId;
  public int $organizerId;
  public string $attendeeFileName;
  public string $attendeeName;
  public string $attendeeComment;
  public int $useFlag;
  public int $likeCount;
  public DateTime|string $created_at;
}
