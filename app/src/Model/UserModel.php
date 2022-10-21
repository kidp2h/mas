<?php
namespace Model;
use Core\Model;
use Core\Schema;
use Schema\UserSchema;

class UserModel extends Model {
  public function __construct(
    string $nameTable = 'users',
    Schema $schema = new UserSchema()
  ) {
    $this->nameTable = $nameTable;
    $this->schema = $schema;
    parent::__construct($schema);
  }
}
?>
