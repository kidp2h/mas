<?php

namespace Core;

use Closure;
use Database;
use mysqli;

class Model {
  protected Schema $schema;
  protected string $nameTable;
  private array $conditions = [];
  public array $fields = [];
  public array $fieldSelect = [];
  public mysqli $connection;
  public function __construct(Schema $schema) {
    $this->schema = $schema;
    $fields = get_class_vars(get_class($this->schema));
    $this->connection = Database::Instance()->getConnect();

    foreach ($fields as $name => $value) {
      array_push($this->fields, $name);
    }
  }

  public function select(...$fields): self {
    foreach ($fields as $name) {
      if (!in_array($name, $this->fields)) {
        echo $name;
        throw new \Exception("Field `{$name}` not available !", 1);
      }
    }

    $this->fieldSelect = $fields;
    return $this;
  }
  public function where(string $field, string $operator, string $value): self {
    array_push($this->conditions, "{$field} {$operator} {$value}");
    return $this;
  }

  public function orWhere($query): self {
    array_push($this->conditions, 'or (');
    $query($this);

    array_push($this->conditions, ')');

    echo '<pre>';
    var_dump($this->conditions);
    echo '</pre>';

    return $this;
  }

  public function get() {
    $stringSelect = implode(', ', $this->fieldSelect);
    $stringWhere = '';
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
        if ($i + 1 == count($this->conditions)) {
          echo $this->conditions;
        }
      }
    }
    if (end($this->conditions) == ')') {
      $stringWhere .= '  )';
    } else {
      $stringWhere .= "and {$this->conditions[$i]}";
    }
    echo $stringWhere . '<br>';
    $query = "SELECT {$stringSelect} FROM $this->nameTable WHERE {$stringWhere}";
    echo $query;
  }

  public function nextID(): int {
    return mysqli_query(
      $this->connection,
      "SELECT AUTO_INCREMENT FROM information_schema.TABLES
        WHERE TABLE_SCHEMA = 'mas' AND TABLE_NAME = '{$this->nameTable}';
      "
    );
  }

  public function insert(array $list): void {
    $fields = [];
    $values = [];
    foreach ($list as $field => $value) {
      array_push($fields, $field);
      array_push($values, $value);
    }

    $fields = implode(',', $fields);
    $values = "'" . implode("', '", $values) . "'";

    $queryCommand = "INSERT INTO {$this->nameTable} ({$fields}) VALUES ({$values})";
    echo $queryCommand;
  }
}

?>
