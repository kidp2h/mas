<?php

namespace Core;

class Controller {
  public function render($view, $data = []) {
    $template = new Template($view, $data);
    $template->run();
  }

  public static function error(Response $response) {
    return $response->status(404);
  }
}
