<?php
require_once('database.php');
/**
 * There is an example of usage of database class of Capella
 */
$database = new DatabaseWorker();
$ip = $database->getUserIP();
$database_name = 'capella-storage';
$id = "444jjk3k33";
$extension = "png";
try {

//    example of inserting data
    $database->query('INSERT INTO `' . $database_name . '` (id,extension,ip) VALUES (:id,:extension,:ip)');
    $database->bind(':id', $id);
    $database->bind(':extension', $extension);
    $database->bind(':ip', $ip);
    $database->execute();

//    example for selecting data
//    $database->query('SELECT * FROM  `' . $database_name . '`  WHERE id=12');
//    $database->execute();
//    $result = $database->fetchAll();
//    print_r($result);
} catch (PDOException $e) {
    echo 'Error in loading data to database: ' . $e->getMessage();
}
