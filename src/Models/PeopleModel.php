<?php

namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class PeopleModel extends BaseModel
{
    private $people_table = "people";
    private $address_table = "address";

    public function __construct()
    {
        parent::__construct();
    }
 
    public function getAll(int $laureate_id = null, array $filters = [])
    {
        $filters_value = [];
        $where_value = isset($laureate_id) ? " people.laureateid =  " . $laureate_id : 1;

        $sql = "SELECT * FROM $this->people_table 
        JOIN $this->address_table ON people.addressid = address.addressid 
        JOIN awards_received ON people.laureateid = awards_received.laureateid
        JOIN awards ON awards_received.awardid = awards.awardid
        WHERE " . $where_value;

        if(isset($filters["first_name"])){
            $sql .= " AND first_name LIKE :first_name";
            $filters_value[":first_name"] = $filters["first_name"]."%";
        }

        if(isset($filters["last_name"])){
            $sql .= " AND last_name LIKE :last_name";
            $filters_value[":last_name"] = $filters["last_name"]."%";
        }

        if(isset($filters["country"])){
            $sql .= " AND country LIKE :country";
            $filters_value[":country"] = $filters["country"]."%";
        }

        if(isset($filters["occupation"])){
            $sql .= " AND occupation LIKE :occupation";
            $filters_value[":occupation"] = "%".$filters["occupation"]."%";
        }

        if(isset($filters["award_name"])){
            $sql .= " AND award_name LIKE :award_name";
            $filters_value[":award_name"] = "%".$filters["award_name"]."%";
        }

        return $this->run($sql, $filters_value)->fetchAll();
        // return $this->paginate($sql, $filters_value);
    }
}
