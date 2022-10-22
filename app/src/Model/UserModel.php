<?php
namespace Model;
use Core\Model;
use Core\Schema;
use Schema\UserSchema;

class UserModel extends Model {
  private static self $instance;
  public function __construct(
    string $nameTable = 'users',
    Schema $schema = new UserSchema()
  ) {
    $this->nameTable = $nameTable;
    $this->schema = $schema;
    parent::__construct($schema);
  }

  public static function Instance(): self {
    if (!isset(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }
}
?>
