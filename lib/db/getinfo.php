<?php

require 'database.php';
include "config.php"

$database = new DatabaseWorker();
$database->query("SELECT * FROM `".$config["database_name"]."`");
$database->execute();
$resopnse = $database->fetchAll();
$database_name = 'capella-storage';
$response_array = array();
$index = 0;
echo "<table border=1><tr><td><p>ID</p></td><td>DT_ADD</td><td>EXTENSION</td><td>IP</td></tr>";
foreach ($resopnse as $line => $line_info){
	$resopnse_array[$index++] = array(
					'id'     	=> $line_info['id'],
					'dt_add' 	=> $line_info['dt_add'],
					'extension' => $line_info['extension'],
					'ip'        => $line_info['ip']
	);
	echo "<tr><td><p>".$response_array['id']."</p></td><td>".$response_array['dt_add']."</td><td>".substr($response_array['extension'], 6)."</td><td>".$response_array['ip']."</td></tr>";
}
echo "</table>";
?>