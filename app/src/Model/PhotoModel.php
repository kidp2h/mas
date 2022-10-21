<?php 

namespace Model;

use Core\Model;
use Core\Schema;
use Schema\PhotoSchema;

class PhotoModel extends Model {
  public function __construct(
    string $nameTable = 'photos',
    Schema $schema = new PhotoSchema()
  ) {
    $this->nameTable = $nameTable;
    $this->schema = $schema;
    parent::__construct($schema);
  }
}
?>
