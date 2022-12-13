<?php

namespace Core;

abstract class SingletonBase {
  private static $instances = array();

  public static function Instance(): static {
    $class = get_called_class();
    if (array_key_exists($class, self::$instances) === false) self::$instances[$class] = new $class();
    return self::$instances[$class];
  }
}
