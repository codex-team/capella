<?php

/**
 * Class Env for working with enviromental variables
 */
class Env
{
    /**
     * Return value from .env or null
     *
     * @param string $param
     *
     * @return string
     */
    public static function get($param)
    {
        return !empty($_SERVER[$param]) ? $_SERVER[$param] : null;
    }

    /**
     * Set server config variable
     *
     * @param string $param
     * @param string $value
     *
     * @return string $value
     */
    public static function set($param, $value)
    {
        return $_SERVER[$param] = $value;
    }

    /**
     * Return boolean value for param from .env
     *
     * @param string $param
     *
     * @return bool
     */
    public static function getBool($param)
    {
        $value = filter_var(self::get($param), FILTER_VALIDATE_BOOLEAN);

        return $value;
    }

    /**
     * Return true if debug flag enabled in the .env config file
     *
     * @return bool
     */
    public static function debug()
    {
        return self::getBool('DEBUG');
    }
}
