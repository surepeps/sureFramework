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
    protected static $group_by;

    /**
     *
     * Order by
     */
    protected static $order_by;

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
     *
     * Query initialization
     */
    protected static $sqlQuery ;

    /**
     *
     * Offset
     */
    protected static $offset;

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
            $databaseData = Filehandling::require_file('config/database.php');
            extract($databaseData);
            $dsn = 'mysql:dbname='.$database.';host='.$host.'';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_PERSISTENT => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "set NAMES " . $charset . " COLLATE " . $collation,
            ];
            try {
               static::$connection = new PDO($dsn, $username, $password, $options);
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
    private static function instance()
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
            $sqlQuery .= "FROM " . static::$table . " ";
            $sqlQuery .= static::$join . " ";
            $sqlQuery .= static::$where . " ";
            $sqlQuery .= static::$group_by . " ";
            $sqlQuery .= static::$having  . " ";
            $sqlQuery .= static::$order_by  . " ";
            $sqlQuery .= static::$limit . " ";
            $sqlQuery .= static::$offset ." ";
        }

        static::$sqlQuery = $sqlQuery;
        static::$binding = array_merge(static::$where_binding, static::$having_binding);

//        return static::$sqlQuery;
        return static::instance();
    }

    /**
     * Select data from table
     * @param string @param
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
     * Release query written
     *
     */
    public static function getQuery()
    {
         static::query();

        return static::instance();
    }






}