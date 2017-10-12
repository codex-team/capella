<?php
require '../vendor/autoload.php';
const FILTERS = array(
    'c' => 'crop',
    'r' => 'resize',
);
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri        = $_SERVER['REQUEST_URI'];

$path      = rawurldecode($uri);
$pathParts = explode('/', $path);
$id        = $pathParts[1];
$filters   = array_splice($pathParts, 2);
// '/' on the end exception
if (end($filters) == '') {
    array_pop($filters);
}

$filtersData = parseFilters($filters);

$data = array('id' => $id, 'filters' => $filtersData);
//print_r(json_encode($data));
// image -> show($data);

function parseFilters($filters)
{
    $len = count($filters);
    if ($len == 0) {
        $filtersData = false;
    } else {
        $filtersData = array();
        if ($len == 1) {
            $filtersData = [['status' => 'Not enough info']];
        }
        for ($filterId = 0; $filterId < $len - 1; $filterId += 2) {
            if (array_key_exists($filters[$filterId], FILTERS)) {
                $params = explode('&', $filters[$filterId + 1]);
                if (strlen($filters[$filterId + 1]) > 0) {
                    $data = array('status' => 'Ok', 'filter' => FILTERS[$filters[$filterId]], 'params' => $params);
                } else {
                    $data = array('status' => 'Not enough info to ' . FILTERS[$filters[$filterId]],
                                  'filter' => FILTERS[$filters[$filterId]]);
                }
            } else {
                $data = array('status' => 'Filter syntax error');
            }
            array_push($filtersData, $data);
        }
    }
    return $filtersData;
}
