<?php

namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

/**
 * OrganizationsModel
 */
class OrganizationsModel extends BaseModel
{
    /**
     * org_table
     * @var string
     */
    private $org_table = "organizations";
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
     * __construct
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * getAll
     * get all organizations
     * @param int|null $organization_id
     * @param array $filters
     * @return mixed
     */
    public function getAll(int $organization_id = null, array $filters = [])
    {
        $filters_value = [];
        $where_value = isset($organization_id) ? "orgid =" . $organization_id : 1;

        $sql = "SELECT organizations.orgid, organizations.orgname, organizations.phonenumber, organizations.email, organizations.addressid, address.* FROM $this->org_table 
        JOIN $this->people_table ON people.laureateid = organizations.laureateid 
        JOIN $this->address_table ON address.addressid = organizations.addressid 
        WHERE " . $where_value;

        if (isset($filters["org_name"])) {
            $sql .= " AND orgname LIKE :org_name";
            $filters_value[":org_name"] = "%" . $filters["org_name"] . "%";
        }

        if (isset($filters["country"])) {
            $sql .= " AND country LIKE :country";
            $filters_value[":country"] = "%" . $filters["country"] . "%";
        }

        // return $this->run($sql, $filters_value)->fetchAll();
        return $this->paginate($sql, $filters_value);
    }
    /**
     * addOrg
     * @param array $org
     * @return void
     */
    public function createOrg(array $org)
    {
        $this->insert($this->org_table, $org);
    }

    /**
     * putOrg
     * @param array $org
     * @param int $org_id
     * @return void
     */
    public function updateOrg(array $org, int $org_id)
    {
        $this->update($this->org_table, $org, ["orgid" => $org_id]);
    }

    /**
     * deleteOrgById
     * @param int $org_id
     * @return mixed
     */
    public function deleteOrgById(int $org_id)
    {
        return $this->delete($this->org_table, ['orgid'=> $org_id]);
    }

    /**
     * getByOrgId
     * @param int $org_id
     * @return mixed
     */
    public function getByOrgId(int $org_id)
    {
        $sql = "SELECT orgid FROM $this->org_table WHERE orgid = :org_id";
        return $this->run($sql, [":org_id" => $org_id])->fetch();
    }

}
