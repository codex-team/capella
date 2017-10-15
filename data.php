<?php 
require_once('database.php'); 
/*using of class:
database in real example
*/
$database = new DataBaseWorker();
$ip=$database->getUserIP();
/*getting info about file somewhere in class:
$id='1';
$extension='jpg';*/
$database->query('INSERT INTO `capella-storage` (id,extension,ip) VALUES (:id,:extension,:ip)');
$database->bind(':id', $id);
$database->bind(':extension', $extension);
$database->bind(':ip', $ip);
$database->execute();
?>