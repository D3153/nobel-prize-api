<?php

namespace Vanier\Api\Models;

class PublicationsModel extends BaseModel
{
    private $table_name_pub = "publications";
    private $table_name_p = "people";
    private $table_name_f = "fields";

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        $filters_value = [];

        $sql = "SELECT publications.publicationid, publication_name, first_name, field_name, publication_desc 
        FROM $this->table_name_pub
        JOIN $this->table_name_p on people.laureateid = publications.laureateid 
        JOIN $this->table_name_f on fields.fieldid = publications.fieldid WHERE 1";

        return $this->run($sql, $filters_value)->fetchAll();
        // return $this->paginate($sql, $filters_value);
    }
}
