<?php

namespace Vanier\Api\Models;

class AwardsModel extends BaseModel
{
    private $table_name_a = "awards";
    private $table_name_f = "fields";

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(int $award_id = null, array $filters = [])
    {
        $filters_value = [];
        $where_value = isset($laureate_id) ? " laureateid =  " . $laureate_id : 1;

        $sql = "SELECT awardid, award_name, field_name, award_desc FROM $this->table_name_a 
        JOIN $this->table_name_f on awards.fieldid = fields.fieldid 
        WHERE " . $where_value;

        return $this->run($sql, $filters_value)->fetchAll();
        // return $this->paginate($sql, $filters_value);
    }
}
