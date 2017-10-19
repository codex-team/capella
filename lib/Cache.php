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
 * $imgID = $cache->getObj($imgID+implode($filters));
 *
 * @example Put object
 * $cache->putObj($img, $imgID+implode($filters));
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
     * Key generate
     * @param {string} Generate key
     * @return Hash
     */
    function keyGenerate($string) {
        return hash('sha256', $string);
    }

    /**
     * Get object
     * @param {string} Object name
     * @return if success return object else return 0
     */
    public function getObj($objName) {
        $cacheObj = $this->memcacheObj->get(keyGenerate($objName));
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
    public function putObj($obj, $objName)
    {
        $this->memcacheObj->set(keyGenerate($objName), $obj, MEMCACHE_COMPRESSED, 60 * 60);
    }
}
?>