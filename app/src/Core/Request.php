<?php

namespace Core;

class Request {
  public array $params;
  public function __construct() {
    $this->params = [];
  }

  public function param($name) {
    return $this->params[$name];
  }
  public function path() {
    return $_SERVER['REDIRECT_URL'];
  }

  public function method() {
    return strtoupper($_SERVER['REQUEST_METHOD']);
  }
  public function body() {
    $body = [];
    if ($this->method() === 'GET') {
      foreach ($_GET as $key) {
        $body[$key] = filter_input(
          INPUT_GET,
          $key,
          FILTER_SANITIZE_SPECIAL_CHARS
        );
      }
    }
    if ($this->method() === 'POST') {
      foreach ($_POST as $key => $value) {
        $body[$key] = filter_input(
          INPUT_POST,
          $key,
          FILTER_SANITIZE_SPECIAL_CHARS
        );
      }
      foreach ($_FILES as $key => $value) {
        $body[$key] = $_FILES[$key];
      }
    }
    return $body;
  }
  public function setParams(array $params) {
    $this->params = $params;
  }
}
