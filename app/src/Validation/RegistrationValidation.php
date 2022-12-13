<?php

namespace Validation;
use Core\Validation;

class RegistrationValidation extends Validation {
  public string $name = '';
  public string $email = '';
  public string $password = '';
  public string $confirmPassword = '';

  public function rules() {
    return [
      'name' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 6]],
      'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
      'password' => [[self::RULE_MIN, 'min' => 8]],
    ];
  }
}
?>
