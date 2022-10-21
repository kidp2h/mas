<?php

namespace Core;

class Controller {
  public function render($view) {
    echo $view;
  }

  public static function error(Response $response) {
    return $response->status(404);
  }
}
