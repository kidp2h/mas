<?php

namespace Core;

abstract class Validation {
  public const RULE_REQUIRED = 'required';
  public const RULE_EMAIL = 'email';
  public const RULE_MIN = 'min';
  public const RULE_MAX = 'max';
  public const RULE_MATCH = 'match';
  public const RULE_OPTIONAL = 'optional';
  public array $errors = [];

  abstract public function rules();

  public function loadData($data) {
    foreach ($data as $key => $value) {
      if (property_exists($this, $key)) {
        if ($value == "undefined" || $value == "null") {
          $this->{$key} = null;
          continue;
        }
        $this->{$key} = $value;
      }
    }
  }
  public function addError($attr, $rule, $params = []) {
    $message = $this->errorMessages()[$rule] ?? '';
    foreach ($params as $key => $value) {
      $message = str_replace("{{$key}}", $value, $message);
    }
    $this->errors[$attr][] = $message;
  }
  public function errorMessages() {
    return [
      self::RULE_REQUIRED => 'このフィールドを空にすることはできません',
      self::RULE_EMAIL => 'メールアドレスが無効です',
      self::RULE_MIN => 'このフィールドの最小長は、{min}',
      self::RULE_MAX => 'このフィールドの最大長は、{max}',
      self::RULE_MATCH => 'このフィールドはフィールドと同じである必要があります {match}',
    ];
  }
  public function validate() {
    foreach ($this->rules() as $attr => $rules) {
      $value = $this->{$attr};
      foreach ($rules as $rule) {
        $ruleName = $rule;
        if (!is_string($ruleName)) {
          $ruleName = $rule[0];
        }
        if ($ruleName === self::RULE_REQUIRED && !$value && $value !== 0) {
          $this->addError($attr, self::RULE_REQUIRED);
        }

        if (
          $ruleName === self::RULE_EMAIL &&
          !filter_var($value, FILTER_VALIDATE_EMAIL)
        ) {
          $this->addError($attr, self::RULE_EMAIL);
        }

        if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
          $this->addError($attr, self::RULE_MIN, ['min' => $rule['min']]);
        }

        if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
          $this->addError($attr, self::RULE_MAX);
        }
        if (
          $ruleName === self::RULE_MATCH &&
          $value !== $this->{$rule['match']}
        ) {
          $this->addError($attr, self::RULE_MATCH, ['match' => $rule['match']]);
        }
      }
    }
    if (count($this->errors) == 0) {
      return true;
    } else {
      return $this->errors;
    }
  }
  public function hasError($attr) {
    return $this->errors[$attr] ?? false;
  }
  public function getFirstError($attr) {
    return $this->errors[$attr][0] ?? false;
  }
}
