<?php

namespace Vanier\Api\Models;

class AwardsModel extends BaseModel
{
    private $award_table = "awards";
    private $field_table = "fields";
    private $awards_received_table = "awards_received";

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(int $award_id = null, array $filters = [])
    {
        $filters_value = [];

        $where_value = isset($award_id) ? "awardid = " . $award_id : 1;

        $sql = "SELECT awards.awardid, award_name, field_name, award_desc, yearReceived
        FROM $this->award_table 
        JOIN $this->field_table on awards.fieldid = fields.fieldid 
        JOIN $this->awards_received_table on awards.awardid = awards_received.awardid
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

    public function updateAward(array $award, int $award_id)
    {
        //  Clean the received data contained in the array
        //  pick some of the contained elements and use them in the insert statement
        $this->update($this->award_table, $award, ["awardid" => $award_id]);
    }

}
