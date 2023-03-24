<?php

namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class PeopleModel extends BaseModel
{
    private $table_name1 = "people";
    private $table_name2 = "address";

    public function __construct()
    {
        parent::__construct();
    }
 
    public function getAll()
    {
        $filters_value = [];

        $sql = "SELECT * FROM $this->table_name1 
        JOIN $this->table_name2 ON people.addressid = address.addressid 
        WHERE 1";

        return $this->run($sql, $filters_value)->fetchAll();
        // return $this->paginate($sql, $filters_value);
    }
}
