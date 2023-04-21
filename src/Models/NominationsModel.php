<?php

namespace Vanier\Api\Models;

class NominationsModel extends BaseModel
{
    private $nomination_table = "nominations";
    private $people_table = "people";
    private $field_table = "fields";
    private $award_table = "awards";

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(int $nomination_id = null, array $filters = [] )
    {
        $filters_value = [];
        $where_value = isset($nomination_id) ? " nominationid =  " . $nomination_id : 1;

        $sql = "SELECT nominations.nominationid, 
        nominations.laureateid, first_name, last_name, occupation, 
        nominations.fieldid, field_name, nomination_reason, 
        nominations.yearofnomination, nominators, award_name
        FROM $this->nomination_table
        JOIN $this->people_table ON nominations.laureateid = people.laureateid
        JOIN $this->field_table ON nominations.fieldid = fields.fieldid
        JOIN $this->award_table ON fields.fieldid = awards.fieldid
        WHERE " . $where_value;

        if (isset($filters["nominators"])) {
            $sql .= " AND nominators LIKE :nominators";
            $filters_value[":nominators"] = "%" . $filters["nominators"] . "%";
        }

        if (isset($filters["award"])) {
            $sql .= " AND award_name LIKE :award";
            $filters_value[":award"] = "%" . $filters["award"] . "%";
        }

        if (isset($filters["yearMax"])) {
            $sql .= " AND yearofnomination <= :yearMax";
            $filters_value[":yearMax"] = $filters["yearMax"];
        }

        if (isset($filters["yearMin"])) {
            $sql .= " AND yearofnomination >= :yearMin";
            $filters_value[":yearMin"] = $filters["yearMin"];
        }
        // echo $sql;exit;
        return $this->run($sql, $filters_value)->fetchAll();
        // return $this->paginate($sql, $filters_value);
    }

    public function createNomination(array $nomination)
    {
        //  Clean the received data contained in the array
        //  pick some of the contained elements and use them in the insert statement
        $this->insert($this->nomination_table, $nomination);
    }

    public function updateNomination(array $nomination, int $nomination_id)
    {
        //  Clean the received data contained in the array
        //  pick some of the contained elements and use them in the insert statement
        $this->update($this->nomination_table, $nomination, ["nominationid" => $nomination_id]);
    }

}
