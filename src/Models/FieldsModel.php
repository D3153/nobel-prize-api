<?php

namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class FieldsModel extends BaseModel
{
    private $table_name1 = 'fields';
public function getAll(int $field_id = null, array $filters = [])
{
    $filters_value = [];
    $where_value = isset($field_id) ? " fieldid =  " . $field_id : 1;

    $sql = "SELECT * FROM $this->table_name1
    WHERE " . $where_value;

    if(isset($filters["field_name"])){
        $sql .= " AND field_name LIKE :field_name";
        $filters_value[":field_name"] = $filters["field_name"]."%";
    }

    return $this->run($sql, $filters_value)->fetchAll();
    // return $this->paginate($sql, $filters_value);
}
}
