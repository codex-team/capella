<?php

/**
 * Class UriDispatcher
 */
class UriDispatcher
{
    public $path;
    public $filterList;
    public $id;

    private $pathParts;
    private $rawFilters;

    /**
     * @param string $uri URI to dispatch
     * @param array $filterList Dictionary of supported filters
     */
    public function __construct($uri, $filterList)
    {
        $this->path = rawurldecode($uri);
        // Splits path into parts, cutting the first '/' for elements purity
        $this->pathParts = explode('/', substr($this->path, 1));
        $this->id        = $this->pathParts[0];
        // Slices filters and additional parameters list from pathParts
        $this->rawFilters = array_slice($this->pathParts, 1);
        // Dictionary of supported filters
        $this->filterList = $filterList;
    }

    /**
     * Parses all pairs param=paramContent from array and creates [$param => $paramContent]
     * @param array $rawParams Dictionary of supported filters
     * @return array
     */
    public function parseParamsData($rawParams)
    {
        $params = array();
        foreach ($rawParams as $rawParam)
        {
            $paramPair = explode('=', $rawParam);
            $params[$paramPair[0]] = $paramPair[1];
        }
        return $params;
    }

    /**
     * Parses raw filters element and returns formatted filter data dictionary
     * @param $filterId Filter index in raw filters list
     */
    public function parseFilterData($filterId)
    {
        // Check if the filter exists
        if (array_key_exists($this->rawFilters[$filterId], $this->filterList)) {

            $filter = $this->filterList[$this->rawFilters[$filterId]];

            // "{id}/{filter_name}//{filter_name}/..." case check
            if (strlen($this->rawFilters[$filterId + 1]) > 0) {

                // Get params with content from /{param1=param1Content}&{param2=param2Content}...
                $rawParams = explode('&', $this->rawFilters[$filterId + 1]);
                // Get structured params array
                $params    = $this->parseParamsData($rawParams);
                $data      = array('status' => 'Ok', 'filter' => $filter, 'params' => $params);
            } else {
                $data = array('status' => 'Not enough info to ' . $filter, 'filter' => $filter);
            }
        } else {
            $data = array('status' => 'Filter syntax error');
        }
        
        return $data;
    }

    /**
     * Parses raw filters list and returns formatted filters data array
     * @return array in format [['status' => $f1Status,'filter1' => $f1Title, 'params' => f1Params],
     * ['status' => $f2Status,'filter1' => $f2Title, 'params' => f2Params]]
     */
    public function parseFilters()
    {
        $rawFiltersCount = count($this->rawFilters);
        if ($rawFiltersCount == 0) {
            $filtersData = false;
        } else {
            $filtersData = array();

            // "{id}/{filter_name}" only case check
            if ($rawFiltersCount == 1) {
                $filtersData = [['status' => 'Not enough info']];
            }

            // Raw filters' data loop
            for ($filterId = 0; $filterId < $rawFiltersCount - 1; $filterId += 2) {
                $data = $this->parseFilterData($filterId);

                // Push output data for one filter
                array_push($filtersData, $data);
            }
        }

        return $filtersData;
    }
}

?>