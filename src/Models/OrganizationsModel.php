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
 
    public function getAll(int $organization_id = null, array $filters = [])
    {
        $filters_value = [];
        $where_value = isset($organization_id) ? "orgid" . $organization_id : 1;
        
        $sql = "SELECT organizations.orgid, organizations.orgname, organizations.phonenumber, organizations.email, organizations.addressid, address.* FROM $this->table_name1 
        JOIN $this->table_name2 ON people.laureateid = organizations.laureateid 
        JOIN $this->table_name3 ON address.addressid = organizations.addressid 
        WHERE " . $where_value;

        if(isset($filters["org_name"])){
            $sql .= " AND orgname LIKE :org_name";
            $filters_value[":org_name"] = "%".$filters_value["org_name"]."%";
        }

        if(isset($filters["country"])){
            $sql .= " AND country LIKE :country";
            $filters_value[":country"] = "%".$filters_value["country"]."%";
        }

        return $this->run($sql, $filters_value)->fetchAll();
        // return $this->paginate($sql, $filters_value);
    }
}