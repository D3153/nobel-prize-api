<?php

namespace Vanier\Api\Models;

/**
 * PublicationsModel
 */
class PublicationsModel extends BaseModel
{
    /**
     * publication_table
     * @var string
     */
    private $publication_table = "publications";
    /**
     * people_table
     * @var string
     */
    private $people_table = "people";
    /**
     * field_table
     * @var string
     */
    private $field_table = "fields";

    /**
     * __construct
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * getAll
     * get all publications
     * @param int|null $publication_id
     * @param array $filters
     * @return mixed
     */
    public function getAll(int $publication_id = null, array $filters = [])
    {
        $filters_value = [];
        $where_value = isset($publication_id) ? " publicationid =  " . $publication_id : 1;

        $sql = "SELECT publications.publicationid, people.laureateid, publication_name, first_name, last_name, field_name, publication_desc 
        FROM $this->publication_table
        JOIN $this->people_table on people.laureateid = publications.laureateid 
        JOIN $this->field_table on fields.fieldid = publications.fieldid 
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

        // return $this->run($sql, $filters_value)->fetchAll();
        return $this->paginate($sql, $filters_value);
    }

    /**
     * createPublication
     * @param array $pub
     * @return void
     */
    public function createPublication(array $pub)
    {
        //  Clean the received data contained in the array
        //  pick some of the contained elements and use them in the insert statement
        $this->insert($this->publication_table, $pub);
    }

    /**
     * updatePublication
     * @param array $pub
     * @param int $pub_id
     * @return void
     */
    public function updatePublication(array $pub, int $pub_id)
    {
        //  Clean the received data contained in the array
        //  pick some of the contained elements and use them in the insert statement
        // var_dump($pub_id, $pub);exit;
        $this->update($this->publication_table, $pub, ["publicationid" => $pub_id]);
        // $this->update($this->publication_table, $pub, ["publicationid" => $pub]);
    }

    /**
     * deletePubById
     * @param int $pub_id
     * @return mixed
     */
    public function deletePubById(int $pub_id)
    {
        return $this->delete($this->publication_table, ['publicationid'=> $pub_id]);
    }

    /**
     * getByPubId
     * @param int $pub_id
     * @return mixed
     */
    public function getByPubId(int $pub_id)
    {
        $sql = "SELECT publicationid FROM $this->publication_table WHERE publicationid = :pub_id";
        return $this->run($sql, [":pub_id" => $pub_id])->fetch();
    }

}
