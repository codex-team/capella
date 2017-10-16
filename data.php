<?php 
require_once('database.php');
/*using of class:
database in real example
*/
$database = new DatabaseWorker();
$ip=$database->getUserIP();
/*we get $id and $extension from name of uploaded photo. example of code:
$id='1';
$extension='jpg';*/
$database->query('INSERT INTO `capella-storage` (id,extension,ip) VALUES (:id,:extension,:ip)');
$database->bind(':id', $id);
$database->bind(':extension', $extension);
$database->bind(':ip', $ip);
$database->execute();
