<?php

namespace Cache;

use Env;

/**
 * @singleton
 * Cache class
 *
 * Requires php driver for Memcache[d]
 *
 * @example get instance
 * $cache = \Cache\Cache::instance();
 * @example set object
 * $cache->set($key, $data[, $exp]);
 * @example get object
 * $data = $cache->get($key);
 * @example delete object
 * $cache->delete($key);
 */

class Cache
{
    /**
     * @var \Memcache|\Memcached
     */
    private $memcacheObj;

    /**
     * @var Cache
     */
    private static $_instance = null;

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Check connection status. Is script connected to database
     *
     * @return bool
     */
    public function isAlive()
    {
        return !!$this->memcacheObj;
    }

    /**
     * Get object
     *
     * @param string $key - cache key
     *
     * @return mixed - cached data
     */
    public function get($key)
    {
        if (is_null($this->memcacheObj)) {
            return null;
        }

        $key = $this->generateKey($key);

        $cacheObj = $this->memcacheObj->get($key);

        if (!empty($cacheObj)) {
            return $cacheObj;
        }

        return null;
    }

    /**
     * Set object
     *
     * @param string $key        - cache key
     * @param mixed  $obj        - data to cache
     * @param int    $timeOfLife - cached data life time
     */
    public function set($key, $obj, $timeOfLife = 3600)
    {
        if (is_null($this->memcacheObj)) {
            return;
        }

        $key = self::generateKey($key);

        /**
         * Memcached and Memcache require not equal number or params
         */
        if (get_class($this->memcacheObj) == 'Memcached') {
            /**
             * Memcached()->set() requires 3 params: $key, $value, $expire
             *
             * @link http://php.net/manual/en/memcached.set.php
             */
            $this->memcacheObj->set($key, $obj, $timeOfLife);
        } else {
            /**
             * Memcache()->set() requires 4 params: $key, $value, $flag, $expire
             *
             * @link http://php.net/manual/en/memcache.set.php
             */
            $this->memcacheObj->set($key, $obj, MEMCACHE_COMPRESSED, $timeOfLife);
        }
    }

    /**
     * Delete object
     *
     * @param string $key - cache key
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
     * Increment item's value
     *
     * @param string $key   - cache key
     * @param int    $value - increment the item by value
     */
    public function increment($key, $value = 1)
    {
        if (is_null($this->memcacheObj)) {
            return;
        }

        $key = self::generateKey($key);

        return $this->memcacheObj->increment($key, $value);
    }

    /**
     * Cache constructor
     */
    private function __construct()
    {
        $this->memcacheObj = null;

        /**
         * If cache was disabled in .env
         */
        if (Env::getBool('DISABLE_CACHE')) {
            return;
        }

        /** Use Memcached module */
        if (class_exists('\Memcached')) {
            $this->memcacheObj = new \Memcached();

        /** Use Memcache module */
        } elseif (class_exists('\Memcache')) {
            $this->memcacheObj = new \Memcache();

        /** If no drivers were found */
        } else {
            return;
        }

        /**
         * Get config params
         */
        $config = $this->getConfig();

        if (!$this->memcacheObj->addServer($config['host'], $config['port'])) {
            $this->memcacheObj = null;
        }
    }

    /**
     * Get config params from env of use defaults
     *
     * @return array
     */
    private function getConfig()
    {
        $config = [
            'host' => Env::get('CACHE_HOST') ?: 'localhost',
            'port' => Env::get('CACHE_PORT') ?: 11211
        ];

        return $config;
    }

    /**
     * Prevent cloning of instance
     */
    private function __clone()
    {
    }

    private function __sleep()
    {
    }

    private function __wakeup()
    {
    }

    /**
     * Generate key for input string
     *
     * @param string $string - string to hash
     *
     * @return string - hashed string
     */
    private function generateKey($string)
    {
        return md5($string);
    }
}
