<?php

//used within the Database.php class file, as it is used within every page on the project
session_start();

class Database
{
    protected static $_dbInstance = null;
    protected $_dbHandle;

    /**
     * Static instance which will be used within every other model class in some way
     * for the connection with the database
     */
    public static function getInstance() {
        $username = 'agd916';
        $password = 'GoldenGolem123!';
        $host = 'poseidon.salford.ac.uk';
        $dbName = 'agd916';

        if (self::$_dbInstance === null) {
            self::$_dbInstance = new self($username, $password, $host, $dbName);
        }
        return self::$_dbInstance;
    }

    public function __construct($username, $password, $host, $database) {
        try {
            $this->_dbHandle = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getdbConnection() {
        return $this->_dbHandle;
    }

    public function __destruct() {
        $this->_dbHandle = null;
    }
}