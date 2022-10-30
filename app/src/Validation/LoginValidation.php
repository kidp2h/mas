<?php

namespace Validation;
use Core\Validation;

class LoginValidation extends Validation {
  public string $name = '';
  public string $email = '';
  public string $password = '';
  public string $confirmPassword = '';

  public function rules() {
    return [
      'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
      'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
    ];
  }
}
?>
