<?php
require_once "config.php";

/**
 * Class DatabaseWorker
 *
 */
class DatabaseWorker
{
    //parameters of connection
    private $host = HOST; //or any other host name
    private $user = USER; //or any user name
    private $pass = PASS; // or any passwd
    private $dbname = DBNAME; //or any database name
    private $dbh;
    private $stmt;

    /**
     * DatabaseWorker constructor.
     */
    public function __construct()
    {
        // Set DSN for PDO connection
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        // Set options for PDO connection
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        // Create a new PDO instanace
        $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
    }

    /**
     * Query to database.
     */
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    /**
     * Binding results to every entry of database
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * executing a database
     */
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     * Getting a IP of user
     */
    public function getUserIP()
    {
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];
        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        return $ip;
    }
}
