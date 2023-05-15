<?php

namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

/**
 * PeopleModel
 */
class PeopleModel extends BaseModel
{
    /**
     * people_table
     * @var string
     */
    private $people_table = "people";
    /**
     * address_table
     * @var string
     */
    private $address_table = "address";
    /**
     * nominations_table
     * @var string
     */
    private $nominations_table = "nominations";

    /**
     * __construct
     */
    public function __construct()
    {
        parent::__construct();
    }
 
    /**
     * getAll
     * get all laureates
     * @param int|null $laureate_id
     * @param array $filters
     * @return mixed
     */
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

        // return $this->run($sql, $filters_value)->fetchAll();
        return $this->paginate($sql, $filters_value);
    }

    /**
     * getDate
     * @param mixed $fname
     * @param mixed $lname
     * @return mixed
     */
    public function getDate($fname, $lname)
    {
        $where = [];

        $sql = "SELECT first_name, last_name, dob, yearofnomination FROM $this->people_table 
        JOIN $this->nominations_table ON people.laureateid = nominations.laureateid 
        WHERE " . 1;

        $sql .= " AND first_name = :first_name";
        $where[":first_name"] = $fname;

        $sql .= " AND last_name = :last_name";
        $where[":last_name"] = $lname;

        return $this->run($sql, $where)->fetch();
    }

    /**
     * createPeople
     * @param array $people
     * @return void
     */
    public function createPeople(array $people)
    {
        //  Clean the received data contained in the array
        //  pick some of the contained elements and use them in the insert statement
        $this->insert($this->people_table, $people);
    }

    /**
     * updatePeople
     * @param array $people
     * @param int $laureate_id
     * @return void
     */
    public function updatePeople(array $people, int $laureate_id)
    {
        //  Clean the received data contained in the array
        //  pick some of the contained elements and use them in the insert statement
        $this->update($this->people_table, $people, ["laureateid" => $laureate_id]);
    }

    /**
     * deletePeopleById
     * @param int $laureate_id
     * @return mixed
     */
    public function deletePeopleById(int $laureate_id)
    {
        return $this->delete($this->people_table, ['laureateid'=> $laureate_id]);
    }

    /**
     * getByPeopleId
     * @param int $laureate_id
     * @return mixed
     */
    public function getByPeopleId(int $laureate_id)
    {
        $sql = "SELECT laureateid FROM $this->people_table WHERE laureateid = :laureate_id";
        return $this->run($sql, [":laureate_id" => $laureate_id])->fetch();
    }

}
