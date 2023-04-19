<?php

namespace Vanier\Api\Models;

use Vanier\Api\Models\BaseModel;

class AddressModel extends BaseModel
{
    private $address_table = "address";

    public function __construct()
    {
        parent::__construct();
    }

    public function createAddress(array $address)
    {
        //  Clean the received data contained in the array
        //  pick some of the contained elements and use them in the insert statement
        $this->insert($this->address_table, $address);
    }
}
