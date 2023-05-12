<?php
namespace Vanier\Api\Models;
use PDO;
use Exception;
use Vanier\Api\Helpers\PaginationHelper;

/**
 * A wrapper class for the PDO MySQL API.
 * This class can be extended for further customization.
 */
class BaseModel
{

    /**
     * holds a database connection.
     */
    protected $db;

    /**
     * The index of the current page.
     * @var int
     */
    private $page_number = 1;

    /**
     * Holds the number of records per page.
     * @var int
     */
    private $records_per_page = 2;

    /**
     * Instantiates the BaseModel.
     * @global array $db_options    database connection options.
     * @param array $options        Optional array of PDO options
     * @throws Exception 
     */
    public function __construct($options = [])
    {
        // Global array defined in includes/app_constants.php
        global $db_options;
        if (!isset($db_options['database'])) {
            throw new Exception('&args[\'database\'] is required');
        }

        if (!isset($db_options['username'])) {
            throw new Exception('&args[\'username\']  is required');
        }
        $default_options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        $options = array_replace($default_options, $options);
        //var_dump($args);exit;
        $type = isset($db_options['type']) ? $db_options['type'] : 'mysql';
        $host = isset($db_options['host']) ? $db_options['host'] : 'localhost';
        $charset = isset($db_options['charset']) ? $db_options['charset'] : 'utf8';
        $port = isset($args['port']) ? 'port=' . $args['port'] . ';' : '';
        $password = isset($db_options['password']) ? $db_options['password'] : '';
        $database = $db_options['database'];
        $username = $db_options['username'];

        $dsn = "mysql:host=$host;dbname=$database;port=$port;charset=utf8mb4";
        $this->db = new PDO($dsn, $username, $password, $options);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->query("SET NAMES utf8mb4");
    }

    /**
     * Pagination function
     */
    protected function paginate(string $sql, array $filters = [], $fetchMode = PDO::FETCH_ASSOC)
    {
        // Step 1, Count how many rows is in the result set (after running $sql).
        $number_of_rows = $this->count($sql, $filters);

        //Step 2. we need to compute the offset (in order to respond to the request we need to know which row to start on)
        $paginator = new PaginationHelper($this->page_number, $this->records_per_page, $number_of_rows);

        //Step 3. get the offset value from the pagination helper
        $offset = $paginator->getOffset();

        //Step 4. add the LIMIT to your query(constrain the number of rows returned by the query)
        $sql .= " LIMIT $this->records_per_page OFFSET $offset "; 

        //Step 5. include paginator data in the response 
        $data = $paginator->getPaginationInfo();

        //Step 6. Execute the constraint query (the one that has LIMIT key word) 
        $data["results"] = $this->run($sql, $filters)->fetchAll(); 

        return $data;
    }


    /**
     * get PDO instance
     * 
     * @return $db PDO instance
     */
    protected function getPdo()
    {
        return $this->db;
    }

 
    /**
     * Run raw sql query 
     * 
     * @param  string $sql       sql query
     * @return void
     */
    protected function raw($sql)
    {
        $this->db->query($sql);
    }

    /**
     * Executes an SQL query using a prepared statement.
     * Arguments can be also passed to further filter the obtained result set.
     * @param  string $sql       sql query
     * @param  array  $args      filtering options that can be added to the query.
     * @return object            returns a PDO object
     */
    protected function run($sql, $args = [])
    {        
        if (empty($args)) {
            return $this->db->query($sql);
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($args);

        return $stmt;
    }

    /**
     * Executes a query and gets an array of matching records.
     * 
     * @param  string $sql       sql query
     * @param  array  $args      filtering options that can be added to the query.
     * @param  object $fetchMode set return mode ie object or array
     * @return object            returns multiple records
     */
    protected function rows($sql, $args = [], $fetchMode = PDO::FETCH_ASSOC)
    {
        return $this->run($sql, $args)->fetchAll($fetchMode);
    }

    /**
     * Finds a record matching the provided filtering options.
     * Can execute a query that joins two or more tables. 
     * Should be used to fetch a single record from a table.
     * 
     * @param  string $sql       sql query
     * @param  array  $args      filtering options that will be appended to the WHERE clause.
     * @param  object $fetchMode set return mode ie object or array
     * @return object            returns single record
     */
    protected function row($sql, $args = [], $fetchMode = PDO::FETCH_ASSOC)
    {        
        return $this->run($sql, $args)->fetch($fetchMode);
    }

    /**
     * Gets a table record by its id.
     * 
     * @param  string $table     name of table
     * @param  integer $id       id of record
     * @param  object $fetchMode set return mode ie object or array
     * @return object            returns single record
     */
    protected function getById($table, $id, $fetchMode = PDO::FETCH_ASSOC)
    {
        return $this->run("SELECT * FROM $table WHERE id = ?", [$id])->fetch($fetchMode);
    }

    /**
     * Gets the number of records contained in the obtained result set.
     * 
     * @param  string $sql       sql query
     * @param  array  $args      filtering options. 
     * @param  object $fetchMode set return mode ie object or array
     * @return integer           returns number of records
     */
    protected function count($sql, $args = [])
    {
        return $this->run($sql, $args)->rowCount();
    }

    /**
     * Gets primary key of last inserted record.
     * Note: should be used after a SELECT statement.
     */
    protected function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * Inserts a new record into the specified table.
     * 
     * @param  string $table the table name where the new data should be inserted.
     * @param  array $data  an associative array of column names (fields) and values.
     *              For example, ["username"=>"frostybee", "email" =>"frostybee@me.com"]
     */
    protected function insert($table, $data)
    {
        //add columns into comma separated string
        $columns = implode(',', array_keys($data));

        //get values
        $values = array_values($data);

        $placeholders = array_map(function ($val) {
            return '?';
        }, array_keys($data));

        //convert array into comma separated string
        $placeholders = implode(',', array_values($placeholders));

        $this->run("INSERT INTO $table ($columns) VALUES ($placeholders)", $values);

        return $this->lastInsertId();
    }

    /**
     * updates one or more records contained in the specified table.
     * 
     * @param  string $table table name
     * @param  array $data  an array containing the names of the field(s) to be updated along with the new value
     * @param  array $where an array containing the filtering operations (it should consist of column names and )
     */
    // protected function update($table, $data, $where)
    // {
    //     //merge data and where together
    //     $collection = array_merge($data, $where);

    //     //collect the values from collection
    //     $values = array_values($collection);

    //     //setup fields
    //     $fieldDetails = null;
    //     foreach ($data as $key => $value) {
    //         $fieldDetails .= "$key = ?,";
    //     }
    //     $fieldDetails = rtrim($fieldDetails, ',');

    //     //setup where 
    //     $whereDetails = null;
    //     $i = 0;
    //     foreach ($where as $key => $value) {
    //         $whereDetails .= $i == 0 ? "$key = ?" : " AND $key = ?";
    //         $i++;
    //     }

    //     $stmt = $this->run("UPDATE $table SET $fieldDetails WHERE $whereDetails", $values);

    //     return $stmt->rowCount();
    // }
    protected function update($table, $data, $where)
    {
        // setup fields
        $fieldDetails = null;
        foreach ($data as $key => $value) {
            $fieldDetails .= "$key = ?,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');

        // setup where 
        $whereDetails = null;
        $i = 0;
        $whereValues = [];
        foreach ($where as $key => $value) {
            $whereDetails .= $i == 0 ? "$key = ?" : " AND $key = ?";
            $whereValues[] = $value;
            $i++;
        }   

          //merge data and where together
          //$collection = array_merge($data, $where);

          //collect the values from collection
          //$values = array_values($collection);
          
          // merge data and where together
        $values = array_merge(array_values($data), $whereValues);

        $stmt = $this->run("UPDATE $table SET $fieldDetails WHERE $whereDetails", $values);

        return $stmt->rowCount();
    }

    /**
     * Deletes one or more records.
     * 
     * @param  string $table table name
     * @param  array $where an array containing the filtering operation. 
     * Note that those operations will eb appeNded to the WHERE Clause of the DELETE query. 
     * @param  integer $limit limit number of records
     */
    protected function delete($table, $where, $limit = 1)
    {
        //collect the values from collection
        $values = array_values($where);

        //setup where 
        $whereDetails = null;
        $i = 0;
        foreach ($where as $key => $value) {
            $whereDetails .= $i == 0 ? "$key = ?" : " AND $key = ?";
            $i++;
        }

        //if limit is a number use a limit on the query
        if (is_numeric($limit)) {
            $limit = "LIMIT $limit";
        }
        
        $stmt = $this->run("DELETE FROM $table WHERE $whereDetails $limit", $values);

        return $stmt->rowCount();
    }

    /**
     * Delete all records records
     * 
     * @param  string $table table name
     */
    protected function deleteAll($table)
    {
        $stmt = $this->run("DELETE FROM $table");

        return $stmt->rowCount();
    }

    /**
     * Delete record by id
     * 
     * @param  string $table table name
     * @param  integer $id id of record
     */
    protected function deleteById($table, $id)
    {
        $stmt = $this->run("DELETE FROM $table WHERE id = ?", [$id]);

        return $stmt->rowCount();
    }

    /**
     * Delete record by ids
     * 
     * @param  string $table table name
     * @param  string $column name of column
     * @param  string $ids ids of records
     */
    protected function deleteByIds(string $table, string $column, string $ids)
    {
        $stmt = $this->run("DELETE FROM $table WHERE $column IN ($ids)");

        return $stmt->rowCount();
    }

    /**
     * truncate table
     * 
     * @param  string $table table name
     */
    protected function truncate($table)
    {
        $stmt = $this->run("TRUNCATE TABLE $table");

        return $stmt->rowCount();
    }

    public function setPaginationOptions(int $current_page, int $records_per_page): void
    {
        $this->page_number = $current_page;
        $this->records_per_page = $records_per_page;
    }
}
