<?php

namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class OrganizationsModel extends BaseModel
{
    private $table_name1 = "organizations";
    private $table_name2 = "people";
    private $table_name3 = "address";

    public function __construct()
    {
        parent::__construct();
    }
 
    public function getAll()
    {
        $filters_value = [];

        $sql = "SELECT organizations.orgid, organizations.orgname, organizations.phonenumber, organizations.email, organizations.addressid, address.* FROM $this->table_name1 
        JOIN $this->table_name2 ON people.laureateid = organizations.laureateid 
        JOIN $this->table_name3 ON address.addressid = organizations.addressid 
        WHERE 1";

        return $this->run($sql, $filters_value)->fetchAll();
        // return $this->paginate($sql, $filters_value);
    }
}