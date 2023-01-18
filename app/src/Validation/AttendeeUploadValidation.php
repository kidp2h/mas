<?php

namespace Validation;

use Core\Validation;

class AttendeeUploadValidation extends Validation {
  public array|null $image = array();
  public string $message = '';
  public string $nickname = '';

  public function rules() {
    return [
      'image' => [self::RULE_REQUIRED],
      'message' => [self::RULE_REQUIRED],
      'nickname' => [self::RULE_REQUIRED],
    ];
  }
}
