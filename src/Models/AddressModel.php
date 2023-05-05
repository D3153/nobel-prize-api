<?php

namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

/**
 * AddressModel
 */
class AddressModel extends BaseModel
{
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
     * createAddress
     * @param array $address
     * @return void
     */
    public function createAddress(array $address)
    {
        //  Clean the received data contained in the array
        //  pick some of the contained elements and use them in the insert statement
        $this->insert($this->address_table, $address);
    }

    /**
     * updateAddress
     * @param array $address
     * @param int $address_id
     * @return void
     */
    public function updateAddress(array $address, int $address_id)
    {
        //  Clean the received data contained in the array
        //  pick some of the contained elements and use them in the insert statement
        $this->update($this->address_table, $address, ["addressid" => $address_id]);
    }
}
