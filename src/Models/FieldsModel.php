<?php

namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

/**
 * FieldsModel
 */
class FieldsModel extends BaseModel
{
    /**
     * field_table
     * @var string
     */
    private $field_table = 'fields';
    /**
     * getAll
     * get all fields
     * @param int|null $field_id
     * @param array $filters
     * @return mixed
     */
    public function getAll(int $field_id = null, array $filters = [])
    {
        $filters_value = [];
        $where_value = isset($field_id) ? " fieldid =  " . $field_id : 1;

        $sql = "SELECT * FROM $this->field_table
    WHERE " . $where_value;

        if (isset($filters["field_name"])) {
            $sql .= " AND field_name LIKE :field_name";
            $filters_value[":field_name"] = "%" . $filters["field_name"] . "%";
        }
        return $this->run($sql, $filters_value)->fetchAll();
        // return $this->paginate($sql, $filters_value);
    }

    /**
     * updateField
     * @param array $field
     * @param int $field_id
     * @return void
     */
    public function updateField(array $field, int $field_id)
    {
        //  Clean the received data contained in the array
        //  pick some of the contained elements and use them in the insert statement
        $this->update($this->field_table, $field, ["fieldid" => $field_id]);
    }

}
