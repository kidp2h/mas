<?php

namespace Model;

use Core\Model;
use DateTime;

class Token extends Model {
  public static string $nameTable = 'reset';
  public int $id;
  public string $token;
  public DateTime|string $expire;
}
