<?php

class UriDispatcher
{
    // URI path
    public $path;
    // Dictionary of supported filters
    public $filterList;
    // Image id
    public $id;

    private $pathParts;
    // Filter keys and additional parameters listed in a row
    private $rawFilters;

    public function __construct($uri, $filterList)
    {
        $this->path = rawurldecode($uri);
        // Splits path into parts, cutting the first '/' for elements purity
        $this->pathParts = explode('/', substr($this->path, 1));
        $this->id        = $this->pathParts[0];
        // Slices filters list from pathParts
        $this->rawFilters = array_slice($this->pathParts, 1);
        // Dictionary of supported filters
        $this->filterList = $filterList;
    }

    public function parseFilters()
    {
        $rawFiltersCount = count($this->rawFilters);
        if ($rawFiltersCount == 0) {
            // No filters added
            $filtersData = false;
        } else {
            $filtersData = array();
            // "{id}/{filter_name}" only case check
            if ($rawFiltersCount == 1) {
                $filtersData = [['status' => 'Not enough info']];
            }
            // Raw filters' data loop
            for ($filterId = 0; $filterId < $rawFiltersCount - 1; $filterId += 2) {
                // Check if the filter exists
                if (array_key_exists($this->rawFilters[$filterId], $this->filterList)) {
                    // Filter name
                    $filter = $this->filterList[$this->rawFilters[$filterId]];
                    // "{id}/{filter_name}//{filter_name}/..." case check
                    if (strlen($this->rawFilters[$filterId + 1]) > 0) {
                        // Get params from /{param1}&{param2}...
                        $params = explode('&', $this->rawFilters[$filterId + 1]);
                        $data   = array('status' => 'Ok', 'filter' => $filter, 'params' => $params);
                    } else {
                        $data = array('status' => 'Not enough info to ' . $filter, 'filter' => $filter);
                    }
                } else {
                    $data = array('status' => 'Filter syntax error');
                }
                // Push output data for one filter
                array_push($filtersData, $data);
            }
        }
        // returns [['status':$f1Status,'filter1':$f1Title, 'params': f1Params],
        // ['status':$f2Status,'filter1':$f2Title, 'params': f2Params]]
        return $filtersData;
    }
}
