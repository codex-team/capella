<?php

namespace Cache;

/**
 * @singleton
 * Cache class
 *
 * Requires php driver for Memcache
 *
 * @example get instance
 * $cache = \Cache\Cache::instance();
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
    private static $_instance = null;

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Get object
     *
     * @param string $key — cache key
     * @return array|null|string — cached data
     */
    public function get($key)
    {
        if (is_null($this->memcacheObj)) {
            return null;
        }

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
     * @param string $key — cache key
     * @param * $obj — data to cache
     * @param integer $timeOfLife — cached data life time
     */
    public function set($key, $obj, $timeOfLife = 60 * 60)
    {
        if (is_null($this->memcacheObj)) {
            return;
        }

        $key = self::generateKey($key);

        $this->memcacheObj->set($key, $obj, MEMCACHE_COMPRESSED, $timeOfLife);
    }

    /**
     * Delete object
     *
     * @param string $key — cache key
     */
    public function delete($key)
    {
        if (is_null($this->memcacheObj)) {
            return;
        }

        $key = $this->generateKey($key);

        $this->memcacheObj->delete($key);
    }

    /**
     * Cache constructor
     */
    private function __construct()
    {
        if (!class_exists('\Memcache')) {
            $this->memcacheObj = null;
            return;
        };

        /** Set default config params */
        $config = array(
            'host' => 'localhost',
            'port' => 11211
        );

        $pathToConfig = dirname(__FILE__) . '/config.php';

        /** Override default config params */
        if (file_exists($pathToConfig)) {
            $config = include "config.php";
        }

        $this->memcacheObj = new \Memcache();

        if (!$this->memcacheObj->addServer($config['host'], $config['port'])) {
            $this->memcacheObj = null;
        };
    }

    /**
     * Prevent cloning of instance
     */
    private function __clone() {}
    private function __sleep () {}
    private function __wakeup () {}

    /**
     * Generate key for input string
     *
     * @param string $string — string to hash
     * @return string — hashed string
     */
    private function generateKey($string)
    {
        return md5($string);
    }
}
