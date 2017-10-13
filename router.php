<?php
require 'Dispatcher.php';
//Dictionary of supported filters
const FILTERS = array(
    'c' => 'crop',
    'r' => 'resize',
);
$uri = $_SERVER['REQUEST_URI'];

$dispatcher  = new UriDispatcher($uri, FILTERS);
$filtersData = $dispatcher->parseFilters();
$imageData   = array('id' => $dispatcher->id, 'filters' => $filtersData);
print_r($imageData);
// Call image -> show($data);