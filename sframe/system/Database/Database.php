<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: Database
 * YEAR: 2022
 */


namespace sFrameApp\Database;

use Exception;
use sFrameApp\FileHandling\Filehandling;
use PDO;
use PDOException;
use sFrameApp\Http\Request;
use sFrameApp\Url\Url;

class Database
{
    /**
     *
     * Database instance
     */
    protected static $instance;

    /**
     *
     * Database connection
     */
    protected static $connection;

    /**
     *
     * table name
     */
    protected static $table;

    /**
     *
     * Select initialization
     */
    protected static $select;

    /**
     *
     * Join
     */
    protected static $join;

    /**
     *
     * Where
     */
    protected static $where;

    /**
     *
     * Group by
     */
    protected static $groupBy;

    /**
     *
     * Order by
     */
    protected static $orderBy;

    /**
     *
     * Having
     */
    protected static $having;

    /**
     *
     * Limit
     */
    protected static $limit;

    /**
     * Setter
     *
     */
    protected static $setter;

    /**
     *
     * Query initialization
     */
    protected static $sqlQuery ;

    /**
     *
     * Offset
     */
    protected static $offSet;

    /**
     *
     * Where binding
     */
    protected static $where_binding = [];

    /**
     *
     * Having binding
     */
    protected static $having_binding = [];

    /**
     *
     * Binding
     */
    protected static $binding = [];


    /**
     *
     * constructor
     */
    private function __construct() {}

    /**
     *
     * connection
     * @return void
     */
    private static function dbConnect()
    {
        if (!static::$connection){

            if (Filehandling::fileChecker('.env')){
                requiredEnv();
                $database = collectEnv('DB_NAME');
                $host = collectEnv('DB_HOST');
                $port = collectEnv('DB_PORT');
                $charset = collectEnv('CHARSET');
                $collation = collectEnv('COLLATION');
                $username = collectEnv('DB_USER');
                $password = collectEnv('DB_PASS');

            } else {

                $databaseData = Filehandling::require_file('config/database.php');
                extract($databaseData);

            }

            $dsn = 'mysql:dbname='.$database.';host='.$host.'';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_PERSISTENT => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "set NAMES " . $charset . " COLLATE " . $collation,
            ];
            try {
               static::$connection = new PDO($dsn, $username ,$password , $options);
            } catch (PDOException $ex) {
                throw new Exception($ex->getMessage());
            }

        }

    }

    /**
     *
     * instance of this class page
     *
     */
    public static function instance()
    {
        static::dbConnect();
        if (! self::$instance){
            self::$instance = new Database();
        }
        return self::$instance;
    }


    /**
     *
     * method that takes in sql query
     *
     * @param string|null $sqlQuery
     * @return Database|string
     */
    public static function query(string $sqlQuery = null)
    {
        static::instance();
        if ($sqlQuery == null) {
            if (!static::$table){
                throw new Exception("Sql Could not find this table");
            }

           // Sql query writeup
            $sqlQuery = "SELECT ";
            $sqlQuery .= static::$select ?: " * ";
            $sqlQuery .= " FROM " . static::$table . " ";
            $sqlQuery .= static::$join . " ";
            $sqlQuery .= static::$where . " ";
            $sqlQuery .= static::$groupBy . " ";
            $sqlQuery .= static::$having  . " ";
            $sqlQuery .= static::$orderBy  . " ";
            $sqlQuery .= static::$limit . " ";
            $sqlQuery .= static::$offSet ." ";
        }

        static::$sqlQuery = $sqlQuery;
        static::$binding = array_merge(static::$where_binding, static::$having_binding);

        return static::instance();
    }

    /**
     * Where Method
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     * @param string|int $type
     *
     * @return object $instance
     */
    public static function where(string $column, string $operator, $value, string $type = null)
    {
        $where = "`" . $column . "`" . $operator . " ? ";
        if ( !static::$where ){
            $statement = " WHERE " . $where;
        } else {
            if ($type == null){
                $statement = " AND " . $where;
            } else {
                $statement = " " . $type . " " . $where;
            }
        }

        static::$where .= $statement;
        static::$where_binding[] = htmlspecialchars($value);

        return static::instance();
    }

    /**
     * Limit
     *
     * @param string $limit
     *
     * @return object $instance
     */
    public static function limit(string $limit)
    {
        static::$limit = " LIMIT " . $limit . " ";

        return static::instance();
    }

    /**
     * Offset
     *
     * @param string $offSet
     *
     * @return object $instance
     */
    public static function offSet(string $offSet)
    {
        static::$offSet = " OFFSET " . $offSet . " ";

        return static::instance();
    }

    /**
     * Or Where Method
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     *
     * @return object $value
     */
    public static function orWhere(string $column, string $operator, string $value)
    {
        static::where($column,$operator,$value, "OR");

        return static::instance();
    }

    /**
     * Join table method
     *
     * @param string $table
     * @param string $first
     * @param string $operator
     * @param string $second
     * @param string $type
     *
     * @return object $type
     */
    public static function join(string $table, string $first, string $operator, string $second, string $type = "INNER")
    {
        static::$join .= " ". $type . " JOIN " . $table . " ON " . $first . " " . $operator . " " . $second. " ";

        return static::instance();
    }


    /**
     *  Right Join Method
     *
     * @param string $table
     * @param string $first
     * @param string $operator
     * @param string $second
     *
     * @return object $instance
     */
    public static function rightJoin(string $table, string $first, string $operator, string $second)
    {
        static::join($table, $first, $operator, $second,'RIGHT');

        return static::instance();
    }

    /**
     *  Left Join Method
     *
     * @param string $table
     * @param string $first
     * @param string $operator
     * @param string $second
     *
     * @return object $instance
     */
    public static function leftJoin(string $table, string $first, string $operator, string $second)
    {
        static::join($table, $first, $operator, $second,'LEFT');

        return static::instance();
    }

    /**
     * Select data from table
     * @return object @instance
     */
    public static function select()
    {
        $select = func_get_args();
        $select = implode(',', $select);

        static::$select = $select;

        return static::instance();
    }

    /**
     * Define table
     *
     * @param string $table
     * @return object $instance
     */
    public static function table(string $table)
    {
        static::$table = $table;

        return static::instance();
    }

    /**
     * Group By
     *
     * @return object $instance
     */
    public static function groupBy()
    {
        $groupBy = func_get_args();
        $groupBy = implode(',', $groupBy);

        static::$groupBy = $groupBy;

        return static::instance();
    }


    /**
     * Having Method
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     *
     * @return object $instance
     */
    public static function having(string $column, string $operator, string $value)
    {
        $having = "`" . $column . "`" . $operator . " ? ";
        if ( !static::$having ){
            $statement = " HAVING " . $having;
        } else {
            $statement = " AND " . $having;
        }

        static::$having .= $statement;
        static::$having_binding[] = htmlspecialchars($value);

        return static::instance();
    }

    /**
     * Order by
     *
     * @param string $column
     * @param string $type
     *
     * @return object $instance
     */
    public static function orderBy(string $column, string $type = null)
    {
        $separate = static::$orderBy ? " , " : " ORDER BY ";
        $type = strtoupper($type);
        $type = ($type != null && in_array($type, ['ASC', 'DESC'])) ? $type : "ASC";
        $statement = $separate . $column . " " . $type . " ";

        static::$orderBy .= $statement;

        return static::instance();
    }

    /**
     * Clear Query after executed Method
     *
     * @return void
     */
    private static function clearQuery()
    {
        static::$select = " ";
        static::$where_binding = [];
        static::$where = " ";
        static::$join = " ";
        static::$limit = " ";
        static::$binding = [];
        static::$offSet = " ";
        static::$orderBy = " ";
        static::$groupBy = " ";
        static::$instance = " ";
        static::$sqlQuery = " ";
        static::$having_binding = [];
        static::$having = " ";
    }


    /**
     * Fetch Execution Method
     *
     * @return object $response
     */
    public static function fetchExecute()
    {
        static::query(static::$sqlQuery);
        $sqlQuery = trim(static::$sqlQuery, ' ');
        $response = static::$connection->prepare($sqlQuery);
        $response->execute(static::$binding);

        static::clearQuery();

        return $response;
    }

    /**
     * Get query result Method
     *
     * @return object $result
     */
    public static function get()
    {
        $inpData = static::fetchExecute();
        return $inpData->fetchAll();
    }

    /**
     * Get first result Method
     *
     * @return object $result
     */
    public static function first()
    {
        $inpData = static::fetchExecute();
        return $inpData->fetch();
    }

    /**
     * Execute
     *
     * @param array $data
     * @param string $sqlQuery
     * @param bool $where
     *
     * @return void
     */
    private static function execute(array $data, string $sqlQuery, bool $where = null)
    {
        static::instance();
        if (!static::$table){
            throw new Exception("Sql Could not find this table");
        }

        foreach ($data as $key => $val){
            static::$setter .= '`' . $key . '` = ?, ';
            static::$binding[] = filter_var($val, FILTER_SANITIZE_STRING);
        }
        static::$setter = trim(static::$setter, ', ');

        $sqlQuery .= static::$setter;
        $sqlQuery .= $where != null ? static::$where . " " : "";

        static::$binding = $where != null ? array_merge(static::$binding, static::$where_binding) : static::$binding;

        $response = static::$connection->prepare($sqlQuery);
        $response->execute(static::$binding);

        static::clearQuery();
    }


    /**
     * Insert query Method
     *
     * @param array $insertData
     *
     * @return bool
     */
    public static function insert(array $insertData)
    {
        $table = static::$table;
        $sqlQuery = "INSERT INTO " . $table . " SET ";
        static::execute($insertData,$sqlQuery);

        $response_id = static::$connection->lastInsertId();
        $obj = static::table($table)->where('user_id', '=', $response_id)->first();

        return true;
    }

    /**
     * Insert and give last inserted data Method
     *
     * @param array $insertData
     *
     * @return object $lastData
     */
    public static function insertGetData(array $insertData)
    {
        $table = static::$table;
        $sqlQuery = "INSERT INTO " . $table . " SET ";
        static::execute($insertData,$sqlQuery);

        $response_id = static::$connection->lastInsertId();
        $lastData = static::table($table)->where('user_id', '=', $response_id)->first();

        return $lastData;
    }


    /**
     * Insert and Give Id as response
     *
     * @param array $insertData
     *
     * @return int $LII
     */
    public static function insertGetId($insertData)
    {
        $table = static::$table;
        $sqlQuery = "INSERT INTO " . $table . " SET ";
        static::execute($insertData,$sqlQuery);

        $response_id = static::$connection->lastInsertId();

        return $response_id;
    }

    /**
     * Update query Method
     *
     * @param array $updateData
     * @return bool
     */
    public static function update(array $updateData)
    {
        $sqlQuery = "UPDATE ". static::$table . " SET ";
        static::execute($updateData, $sqlQuery, true);

        return true;
    }

    /**
     * Delete Method
     *
     * @return bool
     */
    public static function delete()
    {
        $sqlQuery = "DELETE FROM ". static::$table . " ";
        static::execute([], $sqlQuery, true);

        return true;
    }

    /**
     * Pagination
     * @param int $limit
     * @return mixed $resp
     */
    public static function paginator($limit = 15)
    {
        static::query(static::$sqlQuery);
        $sqlQuery = trim(static::$sqlQuery, ' ');
        $resp = static::$connection->prepare($sqlQuery);
        $resp->execute();

        $pages = ceil($resp->rowCount() / $limit);
        $page = Request::get('page');
        $current_pg = (! is_numeric($page) || Request::get('page') < 1) ? "1" : $page;
        $offset = ($current_pg - 1) * $limit;
        static::limit($limit);
        static::offSet($offset);

        static::query();

        $data = static::fetchExecute();
        $result = $data->fetchAll();

        $resp = ['data' => $result, 'items_per_page' => $limit, 'pages' => $pages, 'current_page' => $current_pg];
        return $resp;
    }

    /**
     * Links for paginator
     *
     * @param int $current_pg
     * @param int $pages
     * @return string $result
     */
    public static function paginatorLink(int $current_pg, int $pages)
    {
        $links = '';
        $from = $current_pg - 2;
        $to = $current_pg + 2;
        if ($from < 2){
            $from = 2;
        }

        if ($to >= $pages){
            $diff = $to - $pages + 1;
            $from = ($from > 2) ? $from - $diff : 2;
            $to = $pages - 1;
        }

        if ($from < 2) {
            $from = 1;
        }

        if ($to >= $pages) {
            $to = ($pages - 1);
        }

        if ($pages > 1){
            $links .= "<ul class='pagination mx-auto'>";
            $full_link = Url::path(Request::urlQueryPath());
            $full_link = preg_replace('/\?page=(.*)/', '', $full_link);
            $full_link = preg_replace('/\&page=(.*)/', '', $full_link);

            $c_p_l_a = $current_pg == 1 ? 'active' : '';
            $href = strpos($full_link, '?') ? ($full_link.'&page=1') : ($full_link.'?page=1');
            $links .= "<li class='mx-2 btn btn-warning' $c_p_l_a ><a href='$href'>First</a></li>";

            for ($l = $from; $l <= $to; $l++){
                $c_p_l_a = $current_pg == $l ? 'active' : '';
                $href = strpos($full_link, '?') ? ($full_link.'&page=' . $l) : ($full_link.'?page=' . $l);
                $links .= "<li class='mx-2 btn btn-success' $c_p_l_a ><a href='$href'>$l</a></li>";
            }

            if ($pages > 1){
                $c_p_l_a = $current_pg == 1 ? 'active' : '';
                $href = strpos($full_link, '?') ? ($full_link.'&page='.$pages) : ($full_link.'?page='. $pages);
                $links .= "<li class='mx-2 btn btn-warning' $c_p_l_a ><a class='' href='$href'>Last</a></li>";
            }

            return $links;

        }
    }


    /**
     * Release query written for debugging mode
     *
     */
    public static function getQuery()
    {
         static::query(static::$sqlQuery);

        return static::$sqlQuery;
    }



    /*************************************************************************************************
     * ***********************************************************************************************
     *
     *                                          MIGRATIONS
     *
     * ***********************************************************************************************
     * ***********************************************************************************************
     */


    /**
     * Apply migration / Run Migration
     *
     *
     * @return void
     */
    public static function applyMigration()
    {
        
     }


    /**
     * Create Migration Table
     *
     *
     *
     * @return void
     */
    public static function createMigrationTable()
    {

     }



}