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

        $where_value = isset($award_id) ? "awardid" . $award_id : 1;

        $sql = "SELECT awardid, award_name, field_name, award_desc FROM $this->table_name_a 
        JOIN $this->table_name_f on awards.fieldid = fields.fieldid 
        WHERE " . $where_value;

        if (isset($filters["award_name"])) {
            $sql .= " AND award_name LIKE :award_name";
            $filters_value[":award_name"] = "%" . $filters["award_name"] . "%";
        }

        if (isset($filters["yearReceivedFrom"])) {
            $sql .= " AND yearReceivedFrom LIKE :yearReceivedFrom";
            $filters_value[":yearReceivedFrom"] = "%" . $filters["yearReceivedFrom"] . "%";
        }

        if (isset($filters["yearReceivedTo"])) {
            $sql .= " AND yearReceivedTo LIKE :yearReceivedTo";
            $filters_value[":yearReceivedTo"] = "%" . $filters["yearReceivedTo"] . "%";
        }


        return $this->run($sql, $filters_value)->fetchAll();
        // return $this->paginate($sql, $filters_value);
    }
}
