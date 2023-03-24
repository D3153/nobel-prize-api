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

    public function getAll()
    {
        $filters_value = [];

        $sql = "SELECT nominations.nominationid, 
        nominations.laureateid, first_name, last_name, occupation, 
        nominations.fieldid, field_name, 
        nomination_reason, yearofnomination, nominators FROM $this->table_name1
        JOIN $this->table_name2 ON nominations.laureateid = people.laureateid
        JOIN $this->table_name3 ON nominations.fieldid = fields.fieldid
        WHERE 1";

        return $this->run($sql, $filters_value)->fetchAll();
        // return $this->paginate($sql, $filters_value);
    }
}
