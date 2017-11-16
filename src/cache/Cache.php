<?php

namespace Cache;

// TODO singleton

/**
 * Cache class
 *
 * @example create new class
 * $cache = new \Cache\Cache();
 *
 * @example set object
 * $cache->set($key, $data[, $exp]);
 *
 * @example get object
 * $data = $cache->get($key);
 *
 * @example delete object
 * $cache->delete($key);
 */

class Cache
{

    private $memcacheObj;

    /**
     * Cache constructor
     */
    public function __construct()
    {
        $config = include "config.php";

        $this->memcacheObj = new \Memcache();
        $this->memcacheObj->connect($config['host'], $config['port']) or die('Memcache is not connected');
    }

    /**
     * Generate key for input string
     *
     * @param string $string - indentifier
     * @return string - hashed id
     */
    private function generateKey($string)
    {
        return md5($string);
    }

    /**
     * Get object
     *
     * @param {string} Object name
     * @return if success return object else return null
     */
    public function get($key)
    {
        $key = $this->generateKey($key);

        $cacheObj = $this->memcacheObj->get($key);

        if(!empty($cacheObj)) {
            return $cacheObj;
        }

        return null;
    }

    /**
     * Set object
     *
     * @param Object
     * @param {string} $imageId Object name
     * @param {integer} $timeOfLife time of var life
     */
    public function set($key, $obj, $timeOfLife = 60 * 60)
    {
        $key = $this->generateKey($key);

        $this->memcacheObj->set($key, $obj, MEMCACHE_COMPRESSED, $timeOfLife);
    }

    /**
     * Delete object
     *
     * @param Object name
     */
    public function delete($key)
    {
        $key = $this->generateKey($key);

        $this->memcacheObj->delete($key);
    }
}
?>
