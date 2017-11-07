<?php

$requestUri = explode('?', $_SERVER['REQUEST_URI'])[0];
$requestUri = trim($requestUri, '/');

if ( !$requestUri ) {

	\HTTP\Response::NotFound();

}

?>

capella.ifmo.su/<?= basename($requestUri) ?>
<img src="/<?= basename($requestUri) ?>">
