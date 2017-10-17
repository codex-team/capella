<?php

/**
 * Class DatabaseWorker
 * Example of usage:
 * $database = new DatabaseWorker();
 * $database->query('INSERT INTO ' . $database_name . ' (id,extension,ip) VALUES (:id,:extension,:ip)');
 * $database->bind(':id', $id);
 * $database->bind(':extension', $extension);
 * $database->bind(':ip', $ip);
 * $database->execute();
 *//**/

class DatabaseWorker
{
    /**
     * @var PDO
     * $dbh-database handler
     * $sth-statement handler
     */
    private $dbh;
    private $sth;

    /**
     * DatabaseWorker constructor.
     */
    public function __construct()
    {

        // Including configuration file
        include "config.php";
        // Set DSN(Data Source Name) for PDO connection
        $dsn = 'mysql:host=' . $config['dbhost'] . ';dbname=' . $config['dbname'];
        // Set options for PDO connection
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        // Create a new PDO instanace
        $this->dbh = new PDO($dsn, $config['dbuser'], $config['dbpassword'], $options);
    }

    /**
     * Query to database.
     */
    public function query($query)
    {
        $this->sth = $this->dbh->prepare($query);
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
        $this->sth->bindValue($param, $value, $type);
    }

    /**
     * Execution of result to a database
     */
    public function execute()
    {
        return $this->sth->execute();
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
