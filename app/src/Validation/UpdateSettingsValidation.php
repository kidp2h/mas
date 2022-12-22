<?php

namespace Validation;

use Core\Validation;

class UpdateSettingsValidation extends Validation {
  public array|null $image = array();
  public string $fullname = '';
  public string $eventTitle = '';
  public string $email = '';
  public string $welcomeMessage = '';
  public int $actionFlag = 1;
  public int $QRCodeFlag = 1;

  public function rules() {
    return [
      'image' => [self::RULE_OPTIONAL],
      'fullname' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 1]],
      'eventTitle' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 1]],
      'email' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 1]],
      'actionFlag' => [self::RULE_REQUIRED],
      'QRCodeFlag' => [self::RULE_REQUIRED],
      'welcomeMessage' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 1]],
    ];
  }
}
