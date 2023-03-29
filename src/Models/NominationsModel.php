<?php

namespace Vanier\Api\Models;

class NominationsModel extends BaseModel
{
    private $table_name1 = "nominations";
    private $table_name2 = "people";
    private $table_name3 = "fields";

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(int $nomination_id = null, array $filters = [])
    {
        $filters_value = [];
        $where_value = isset($nomination_id) ? " nominationid =  " . $nomination_id : 1;

        $sql = "SELECT nominations.nominationid, 
        nominations.laureateid, first_name, last_name, occupation, 
        nominations.fieldid, field_name, 
        nomination_reason, yearofnomination, nominators FROM $this->table_name1
        JOIN $this->table_name2 ON nominations.laureateid = people.laureateid
        JOIN $this->table_name3 ON nominations.fieldid = fields.fieldid
        WHERE " . $where_value;

        //yearBefore
        //yearAfter
        //nominators
        //award

        if (isset($filters["yearBefore"])) {
            //TODO: change this sign
            $sql .= " AND yearBefore < :yearBefore";
            $filters_value[":yearBefore"] = "%" . $filters_value["yearBefore"] . "%";
        }

        if (isset($filters["yearAfter"])) {
            $sql .= " AND yearAfter > :yearAfter";
            $filters_value[":yearAfter"] = "%" . $filters_value["yearAfter"] . "%";
        }

        if (isset($filters["nominators"])) {
            $sql .= " AND nominators LIKE :nominators";
            $filters_value[":nominators"] = "%" . $filters_value["nominators"] . "%";
        }

        if (isset($filters["award"])) {
            $sql .= " AND award LIKE :award";
            $filters_value[":award"] = "%" . $filters_value["award"] . "%";
        }

        return $this->run($sql, $filters_value)->fetchAll();
        // return $this->paginate($sql, $filters_value);
    }
}
