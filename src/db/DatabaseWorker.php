<?php

namespace DB;

/**
 * Class DatabaseWorker
 *
 * @example
 * $database = new \DB\DatabaseWorker();
 * $database->query('INSERT INTO ' . $database_name . ' (id,extension,ip) VALUES (:id,:extension,:ip)');
 * $database->bind(':id', $id);
 * $database->bind(':extension', $extension);
 * $database->bind(':ip', $ip);
 * $database->execute();
 */
class DatabaseWorker
{

    public static $uploadsTable = 'uploads';

    /**
     * @var \PDO
     * $statementHandler-statement handler
     */
    private $databaseHandler;
    private $statementHandler;

    /**
     * DatabaseWorker constructor
     */
    public function __construct()
    {
        // Including configuration file
        include "config.php";

        // Set DSN (Data Source Name) for PDO connection
        $dataSourceName = 'mysql:host=' . $config['host'] . ';dbname=' . $config['name'];

        // Set options for PDO connection
        $options = array(
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        );

        // Create a new PDO instanace
        $this->databaseHandler = new \PDO(
            $dataSourceName,
            $config['user'],
            $config['password'],
            $options
        );
    }

    /**
     * Query to database
     */
    public function query($query)
    {
        $this->statementHandler = $this->databaseHandler->prepare($query);
    }

    /**
     * Binding results to every entry of database
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = \PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = \PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_STR;
            }
        }

        $this->statementHandler->bindValue($param, $value, $type);
    }

    /**
     * Execution of result to a database
     */
    public function execute()
    {
        return $this->statementHandler->execute();
    }

    /**
     * Fetching the array result of select
     */
    public function fetchAll()
    {
        return $this->statementHandler->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Fetching result of select
     */
    public function fetch()
    {
        return $this->statementHandler->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Getting a IP of user
     */
    public function getUserIP()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        return $ip;
    }

    public static function save($id, $ext)
    {

        $database = new self();

        $ip = $database->getUserIP();

        $database->query('INSERT INTO `' . self::$uploadsTable . '` (id, extension, ip) VALUES (:id, :extension, :ip)');
        $database->bind(':id', $id);
        $database->bind(':extension', $ext);
        $database->bind(':ip', $ip);

        $database->execute();

    }

    public static function get($id)
    {

        $database = new self();

        $database->query('SELECT * FROM `' . self::$uploadsTable . '` WHERE id=:id');
        $database->bind(':id', $id);

        $result = $database->fetchAll();

        var_dump($result);

    }

}
