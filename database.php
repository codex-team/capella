<?php

class DatabaseWorker{
	//initialization of our database(mysql or maybe another database)
	private $host = 'localhost'; //or any other host name
    private $user = 'root'; //or any user name
    private $pass = ''; // or any passwd
    private $dbname = 'capella'; //or any database name
    
    private $dbh;
    private $error;
    private $stmt;

    public function __construct()
    {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
            );
        // Create a new PDO instanace
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->passs, $options);
        }
        // Catch any errors
        catch(PDOException $e){

            $this->error = $e->getMessage();
            echo 'Подключение не удалось: ' . $this->error;
        }
    }
    //query statement in out class
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }
    //binding results to every entry of database
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
  //executing a database
    public function execute()
    {
        return $this->stmt->execute();
    }
    /*ip of user*/
    function getUserIP()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))  {
            $ip = $forward;
        }
        else  {
            $ip = $remote;
        }
        return $ip;
    }
}



