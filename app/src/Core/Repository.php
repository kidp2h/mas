<?php

namespace Core;

use Model\User;

abstract class Repository extends SingletonBase {
  protected Model $model;
  private string $nameModel;

  public function __construct() {
    $this->model = new (static::$nameModel)();
  }
}
