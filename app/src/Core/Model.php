<?php

namespace Core;

use Database;
use mysqli;

abstract class Model extends SingletonBase {
  public string $table;
  private array $conditions = [];
  private array $sets = [];
  public array $fields = [];
  public array $fieldSelect = [];
  public mysqli $connection;
  public function __construct() {
    $fields = get_class_vars(static::class);
    $this->table = $fields['nameTable'];
    unset($fields["nameTable"]);
    $this->connection = Database::Instance()->getConnect();
    foreach ($fields as $name => $value) {
      array_push($this->fields, $name);
    }
  }

  public function select(...$fields): self {
    foreach ($fields as $name) {
      if (!in_array($name, $this->fields) && $name !== '*') {
        throw new \Exception("Field `{$name}` not available !", 1);
      }
    }

    $this->fieldSelect = $fields;
    return $this;
  }

  public function update() {
    $stringWhere = $this->getStatementWhere();
    $stringSet = $this->getStatementSet();
    try {
      $query = "UPDATE $this->table SET $stringSet WHERE {$stringWhere}";
      $result = $this->execute($query);
      if ($result !== true)
        return ["message" => "Bad statement", "status" => false];
      return ["status" => true];
    } catch (\Throwable $th) {
    }
  }

  public function delete() {
    $stringWhere = $this->getStatementWhere();
    try {
      $query = "DELETE FROM $this->table WHERE {$stringWhere}";
      $result = $this->execute($query);
      if ($result !== true)
        return ["message" => "Bad statement", "status" => false];
      return ["status" => true];
    } catch (\Throwable $th) {
    }
  }
  public function where(string $field, string $operator, string $value): self {
    $pattern = "/{(.*)}/i";
    $match = preg_match($pattern, $value, $matches);
    if ($match) {
      array_push($this->conditions, "{$field} {$operator} {$matches[1]}");
    } else {
      array_push($this->conditions, "{$field} {$operator} '{$value}'");
    }

    return $this;
  }

  public function set($column, $value): self {
    array_push($this->sets, "{$column} = '{$value}'");
    return $this;
  }

  public function orWhere($query): self {
    array_push($this->conditions, 'or (');
    $query($this);

    array_push($this->conditions, ')');

    return $this;
  }

  public function findOne($limit = NULL): static|null {
    $stringSelect = implode(', ', $this->fieldSelect);
    $stringWhere = $this->getStatementWhere();
    $query = "";
    if ($limit) {
      $query = "SELECT {$stringSelect} FROM $this->table WHERE {$stringWhere} LIMIT=$limit";
    } else {
      $query = "SELECT {$stringSelect} FROM $this->table WHERE {$stringWhere}";
    }

    $result = $this->execute($query);
    $resultORM = new static();
    $fetch = $result->fetch_assoc();
    if (!empty($fetch)) {
      foreach ($fetch as $key => $value) {
        $resultORM->$key = $value;
      }

      return $resultORM;
    } else {
      return null;
    }
  }
  public function find($limit = NULL): array|null {
    $stringSelect = implode(', ', $this->fieldSelect);
    $stringWhere = $this->getStatementWhere();
    $query = "";
    if ($limit) {
      $query = "SELECT {$stringSelect} FROM $this->table WHERE {$stringWhere} LIMIT=$limit";
    } else {
      $query = "SELECT {$stringSelect} FROM $this->table WHERE {$stringWhere}";
    }

    $result = $this->execute($query);
    $resultORM = [];
    if ($result->num_rows) {
      while ($data = $result->fetch_assoc()) {
        $tempORM = new static();
        foreach ($data as $key => $value) {
          $tempORM->$key = $value;
        }
        array_push($resultORM, $tempORM);
      }
      return $resultORM;
    } else {
      return null;
    }
  }
  public function getStatementWhere() {
    $stringWhere = "";
    if (empty($this->conditions)) {
      $stringWhere = '1=1';
    } else {
      for ($i = 0; $i < count($this->conditions) - 1; $i++) {
        if (
          str_contains($this->conditions[$i + 1], '(') ||
          str_contains($this->conditions[$i + 1], ')') ||
          str_contains($this->conditions[$i], '(') ||
          str_contains($this->conditions[$i], ')')
        ) {
          $stringWhere .= "{$this->conditions[$i]}  ";
        } else {
          $stringWhere .= "{$this->conditions[$i]} and  ";
        }
      }
      if (end($this->conditions) == ')') {
        $stringWhere .= '  )';
      } else {
        if (count($this->conditions) <= 2) {
          $stringWhere .= "{$this->conditions[$i]}";
        } else {
          $stringWhere .= "and  {$this->conditions[$i]}";
        }
      }
    }

    $this->conditions = [];
    return $stringWhere;
  }

  public function getStatementSet() {
    return implode(",", $this->sets);
  }

  public function nextID(): int {
    return mysqli_query(
      $this->connection,
      "SELECT AUTO_INCREMENT FROM information_schema.TABLES
        WHERE TABLE_SCHEMA = 'mas' AND TABLE_NAME = '{$this->table}';
      "
    );
  }

  public function insert(array $list) {
    $fields = [];
    $values = [];

    foreach ($list as $field => $value) {
      if (in_array($field, $this->fields)) {
        array_push($fields, $field);
        array_push($values, $value);
      }
    }

    $fields = implode(',', $fields);
    $values = "'" . implode("', '", $values) . "'";

    $queryCommand = "INSERT INTO {$this->table} ({$fields}) VALUES ({$values})";
    return $this->execute($queryCommand);
  }

  public function execute($query) {
    try {
      return $this->connection->query($query);
    } catch (\Throwable $th) {
      // duplicate
      switch ($this->connection->errno) {
        case 1062:
          return false;
          break;

        default:
          return $th;
          break;
      }
    }
  }

  public static function query($query) {
    try {
      return Database::Instance()->getConnect()->query($query);
    } catch (\Throwable $th) {
      // duplicate
      switch (Database::Instance()->getConnect()->errno) {
        case 1062:
          return false;
          break;

        default:
          return $th;
          break;
      }
    }
  }

  public static function multiQuery($query) {
    try {
      return Database::Instance()->getConnect()->multi_query($query);
    } catch (\Throwable $th) {
      // duplicate
      switch (Database::Instance()->getConnect()->errno) {
        case 1062:
          return false;
          break;

        default:
          return $th;
          break;
      }
    }
  }
}
