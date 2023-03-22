<?php

namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class FieldsModel extends BaseModel
{
    private $table_name1 = 'fields';
public function getAll()
{
    $filters_value = [];

    $sql = "SELECT * FROM $this->table_name1
    WHERE 1";

    return $this->run($sql, $filters_value)->fetchAll();
    // return $this->paginate($sql, $filters_value);
}
}
