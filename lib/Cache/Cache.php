<?php
/**
 * Cache class
 *
 * @example Require Storage.php
 * require_once 'lib/Cache.php';
 *
 * @example Create new class
 * $cache = new Cache();
 *
 * @example Get object by name
 * $imgID = $cache->getObj($key);
 *
 * @example Put object
 * $cache->putObj($img, $key, $time);
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
        $this->memcacheObj = new Memcache;
        $this->memcacheObj->connect($config['memcacheHost'], $config['port']) or die('Memcache not connect');
    }

    /**
     * Get object
     *
     * @param {string} Object name
     * @return if success return object else return null
     */
    public function getObj($key)
    {
        $cacheObj = $this->memcacheObj->get($key);

        if(!empty($cacheObj)) {
            return $cacheObj;
        }

        return null;
    }


    /**
     * Put object
     *
     * @param Object
     * @param {string} $imageId Object name
     * @param {integer} $timeOfLife time of var life
     */
    public function putObj($obj, $key, $timeOfLife = 60 * 60)
    {
        $this->memcacheObj->set($key, $obj, MEMCACHE_COMPRESSED, $timeOfLife);
    }

    /**
     * Delete object
     * 
     * @param Object name
     */
    public function deleteObj($key) {
        $this->memcacheObj->delete($key);
    }
}
?>
