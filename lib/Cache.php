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
 * $cache->putObj($img, $key);
 */

class Cache {

    const MEMCACHE_HOST = 'localhost';
    const MEMCACHE_PORT =  '11211';

    private $memcacheObj;

    /**
     * Cache constructor
     */
    public function __construct() {
        $this->memcacheObj = new Memcache;
        $this->memcacheObj->connect(MEMCACHE_HOST, MEMCACHE_PORT) or die('Memcache not connect');
    }

    /**
     * Get object
     * @param {string} Object name
     * @return if success return object else return 0
     */
    public function getObj($key) {
        $cacheObj = $this->memcacheObj->get($key);
        if(!empty($cacheObj)) {
            return $cacheObj;
        }
        return 0;
    }


    /**
     * Put object
     * @param Object
     * @param {string} Object name
     */
    public function putObj($obj, $key, $timeOfLife = 60 * 60)
    {
        $this->memcacheObj->set($key, $obj, MEMCACHE_COMPRESSED, $timeOfLife);
    }

    /**
     * Delete object
     * @param Object name
     */
    public function deleteObj($key) {
        $this->memcacheObj->delete($key);
    }
}
?>