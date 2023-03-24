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

    public function getAll(int $publication_id = null)
    {
        $filters_value = [];
        $where_value = isset($publication_id) ? " publicationid =  " . $publication_id : 1;

        $sql = "SELECT publications.publicationid, people.laureateid, publication_name, first_name, field_name, publication_desc 
        FROM $this->table_name_pub
        JOIN $this->table_name_p on people.laureateid = publications.laureateid 
        JOIN $this->table_name_f on fields.fieldid = publications.fieldid WHERE ".$where_value;

        return $this->run($sql, $filters_value)->fetchAll();
        // return $this->paginate($sql, $filters_value);
    }
}
