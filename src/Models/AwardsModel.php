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

    public function getAll()
    {
        $filters_value = [];

        $sql = "SELECT awardid, award_name, field_name, award_desc FROM $this->table_name_a 
        JOIN $this->table_name_f on awards.fieldid = fields.fieldid WHERE 1";

        return $this->run($sql, $filters_value)->fetchAll();
        // return $this->paginate($sql, $filters_value);
    }
}
