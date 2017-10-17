<?php

/**
* Class UriDispatcher
*
* Example usage:
* $dispatcher = new UriDispatcher($uri, FILTERS);
* $imageData  = array(
*    'id'      => $dispatcher->id,
*    'filters' => $dispatcher->parsedFilters,
* );
* where 'filters' are returned in format 
*[
*  [
*      'filter1' => $f1Title, 
*      'params' => f1Params
*  ],
*  [
*      'status' => $f2Status,
*      'filter1' => $f2Title, 
*      'params' => f2Params
*  ]
*]
*/
class UriDispatcher
{
    public $path;
    public $filterList;
    public $id;

    private $pathParts;
    private $rawFilters;

    /**
     * @param {string} $uri URI to dispatch
     * @param {array} $filterList Dictionary of supported filters and patterns in format 
     * ['filterName' => (
     *   'title' => $title, 
     *   'pattern' => '{$varName|$varType}$delimiter{$varName|$varType}[$additionalParameters]'
     * )]
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

        /** {array} in format [['filter1' => $f1Title, 'params' => f1Params],
         * ['status' => $f2Status,'filter1' => $f2Title, 'params' => f2Params]]
         */
        $this->parsedFilters = $this->parseFilters();
    }

    /**
     * Parses raw filters list and returns formatted filters data array
     * @throws Not enough info to parse filters
     * @return {array} in format [['filter1' => $f1Title, 'params' => f1Params],
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
                throw new Exception('Not enough info');
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

    /**
     * Parses raw filters element and returns formatted filter data dictionary
     * @param $filterId Filter index in raw filters list
     * @throws Errors of formatting and info in uri
     */
    public function parseFilterData($filterId)
    {
        // Check if the filter exists
        if (!array_key_exists($this->rawFilters[$filterId], $this->filterList)) {
            throw new Exception('Filter syntax error');
        }

        $filter = $this->filterList[$this->rawFilters[$filterId]]['title'];

        // "{id}/{filter_name}//{filter_name}/..." case check
        if (strlen($this->rawFilters[$filterId + 1]) == 0) {
            throw new Exception('Not enough info to ' . $filter);
        }

        // Get structured params array
        $params = $this->parseParamsData($filterId);
        $data   = array('filter' => $filter, 'params' => $params);
        return $data;
    }

    /**
     * Parses string of parameters by pattern and returns all contained variables with values
     * @param $filterId Filter index in raw filters list
     * @return {array} All variables, contained in parameters, with values
     */
    private function parseParamsData($filterId)
    {
        $paramString = $this->rawFilters[$filterId + 1];
        $pattern     = $this->filterList[$this->rawFilters[$filterId]]['pattern'];
        // Separate main pattern parts from additional
        $patternParts = preg_split("/[[^\]]/", $pattern);
        $params = array();
        for ($partIt = 0; strlen($paramString) > 0 && $partIt < count($patternParts); $partIt++) {

            // Parse string of parameters by pattern part
            $paramsPart  = $this->parseParamsDataPart($paramString, $patternParts[$partIt]);
            $paramString = $paramsPart['paramString'];

            // Merge params from current pattern part
            $params = array_merge($params, $paramsPart['params']);
        }

        return $params;
    }

    /**
     * Parses string of parameters by pattern part and returns all contained variables with values
     * @param $paramString Raw string of parameters
     * @param $pattern Pattern for current $paramString
     * @return {array} All variables, contained in parameters, with values
     */
    private function parseParamsDataPart($paramString, $pattern)
    {
        // Split raw paramString on alternate parts of variable blocks (variable|type) and values
        $paramsParts = preg_split("/[{}]/", $pattern);

        //Check for additional pattern part delimiter
        if ($paramsParts[0] !== '') {
            $paramString = substr($paramString, strlen($paramsParts[0]));
        }
        // Delete meaningless elements beyond variable blocks
        $paramsParts = array_slice($paramsParts, 1, -1);

        $params         = array();
        $paramsPartsCnt = count($paramsParts);

        // Get all parameters data
        for ($it = 0; $it < $paramsPartsCnt - 1; $it += 2) {
            $delimiter = $paramsParts[$it + 1];

            // Structure variable block + value
            $paramData = $this->getParamData(
                $paramsParts[$it],
                $paramString,
                $paramsParts[$it + 1]
            );

            // Cut processed part of raw parameters string
            $paramString                    = substr(strstr($paramString, $delimiter), strlen($delimiter));
            $params[$paramData["variable"]] = $paramData["value"];
        }

        // Process last element (with no delimiter)
        $paramData = $this->getParamData(
            $paramsParts[$paramsPartsCnt - 1],
            $paramString
        );
        $params[$paramData["variable"]] = $paramData["value"];
        $paramString                    = substr($paramString, strlen($paramData["value"]));
        $paramsPart                     = array(
            "paramString" => $paramString,
            "params"      => $params,
        );
        return $paramsPart;
    }

    /**
     * Parses all pairs param=paramContent from array and creates [$param => $paramContent]
     * @param $varBlock String block in format variable|type of parameter
     * @param $paramString Raw string of parameters
     * @param $delimiter Delimiter for current parameter
     * @return {array} Pair "variable" => $variable, "value" => $value
     */
    private function getParamData($varBlock, $paramString, $delimiter = false)
    {
        $variable = explode('|', $varBlock)[0];
        $type     = explode('|', $varBlock)[1];
        if ($delimiter) {
            $value = strstr($paramString, $delimiter, true);
        } else {
            $value = $paramString;
        }

        // Change type from string to certain
        settype($value, $type);
        $param = array(
            "variable" => $variable,
            "value"    => $value,
        );
        return $param;
    }
}
