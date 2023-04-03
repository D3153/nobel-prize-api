<?php

namespace Vanier\Api\Models;

class AwardsModel extends BaseModel
{
    private $table_name_a = "awards";
    private $table_name_f = "fields";
    private $table_name_ar = "awards_received";

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(int $award_id = null, array $filters = [])
    {
        $filters_value = [];

        $where_value = isset($award_id) ? "awardid" . $award_id : 1;

        $sql = "SELECT awards.awardid, award_name, field_name, award_desc, yearReceived
        FROM $this->table_name_a 
        JOIN $this->table_name_f on awards.fieldid = fields.fieldid 
        JOIN $this->table_name_ar on awards.awardid = awards_received.awardid
        WHERE " . $where_value;

        if (isset($filters["award_name"])) {
            $sql .= " AND award_name LIKE :award_name";
            $filters_value[":award_name"] = "%" . $filters["award_name"] . "%";
        }

        if (isset($filters["yearReceivedMin"])) {
            $sql .= " AND yearReceived >= :yearReceivedMin";
            $filters_value[":yearReceivedMin"] = $filters["yearReceivedMin"] . "%";
        }

        if (isset($filters["yearReceivedMax"])) {
            $sql .= " AND yearReceived <= :yearReceivedMax";
            $filters_value[":yearReceivedMax"] = $filters["yearReceivedMax"] . "%";
        }


        return $this->run($sql, $filters_value)->fetchAll();
        // return $this->paginate($sql, $filters_value);
    }
}
