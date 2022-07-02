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
     * constructor
     */
    private function __constructor() {}

    /**
     *
     * connection
     * @throws Exception
     * @return array
     */
    private static function dbConnect()
    {
        if (!static::$connection){
            $databaseData = Filehandling::require_file('config/database.php');
            extract($databaseData);
            $dsn = 'mysql:dbname'.$database.';host='.$host;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_PERSISTENT => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "set NAMES " . $charset . " COLLATE " . $collation,
            ];
            try {
               static::$connection =  new \PDO($dsn, $username, $password, $options);
            } catch (PDOException $ex) {
                throw new Exception($ex->getMessage());
            }

        }

//        return [];
    }

    /**
     *
     * instance of this class page
     */
    public static function instance()
    {
        static::dbConnect();
        if (! self::$instance){
            self::$instance = new Database;
        }

        return self::$instance;
    }
}