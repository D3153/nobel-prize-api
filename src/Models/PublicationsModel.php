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

    public function getAll(int $publication_id = null, array $filters = [])
    {
        $filters_value = [];
        $where_value = isset($publication_id) ? " publicationid =  " . $publication_id : 1;

        $sql = "SELECT publications.publicationid, people.laureateid, publication_name, first_name, last_name, field_name, publication_desc 
        FROM $this->table_name_pub
        JOIN $this->table_name_p on people.laureateid = publications.laureateid 
        JOIN $this->table_name_f on fields.fieldid = publications.fieldid 
        WHERE " . $where_value;

        if(isset($filters["publication_name"])){
            $sql .= " AND publication_name LIKE :publication_name";
            $filters_value[":publication_name"] = "%".$filters["publication_name"]."%";
        }

        if(isset($filters["last_name"])){
            $sql .= " AND last_name LIKE :last_name";
            $filters_value[":last_name"] = "%".$filters["last_name"]."%";
        }

        if(isset($filters["field_name"])){
            $sql .= " AND field_name LIKE :field_name";
            $filters_value[":field_name"] = "%".$filters["field_name"]."%";
        }

        return $this->run($sql, $filters_value)->fetchAll();
        // return $this->paginate($sql, $filters_value);
    }
}
