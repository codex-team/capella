<?php

if ( !isset($_GET['link']) {

	\HTTP\Response::NotFound();

}

?>

capella.ifmo.su/<?= $_GET['link'] ?>
<img src="/<?= $_GET['link']; ?>">

