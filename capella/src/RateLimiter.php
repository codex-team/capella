<?php


use Cache\Cache;

/**
 * @singleton
 *
 * Simple rate limiter module powered by memcache
 *
 * @example
 * if (RateLimiter::instance()->isEnabled()) {
 *     if (! RateLimiter::instance()->check($key)) {
 *         // ...reject request
 *     }
 * }
 */

class RateLimiter
{
    /**
     * Is RateLimiter enabled and Cache works correctly
     * @var bool
     */
    private $isEnabled;

    /**
     * @var RateLimiter
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
     * Private variable and public method to prevent variable outer changes
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Check if client allowed to do an action
     *
     * @param string $key - client identifier
     * @param int|null $quota - max number of images
     * @param int|null $cycle - time interval
     * @return bool|null - if request is allowed
     */
    public function check($key, $quota = null, $cycle = null)
    {
        if (!$this->isEnabled) {
            return null;
        }

        $quota = $quota ?: Env::getInt('RATE_LIMITER_QUOTA');
        $cycle = $cycle ?: Env::getInt('RATE_LIMITER_CYCLE');

        $defaultValue = 1;

        $requestAllowed = true;

        /** Try to get key */
        $isCached = Cache::instance()->get($key);

        if (is_null($isCached)) {
            Cache::instance()->set($key, $defaultValue, $cycle);
            return $requestAllowed;
        }

        if (intval($isCached) < $quota) {
            Cache::instance()->increment($key);
            return $requestAllowed;
        }

        return ! $requestAllowed;
    }

    /**
     * RateLimiter constructor
     */
    private function __construct()
    {
        /** If rate limiter was disabled in .env */
        if (Env::getBool('DISABLE_RATE_LIMITER')) {
            return;
        }

        /** Check if Cache module set up correctly */
        $cache = \Cache\Cache::instance();
        if (!$cache->isAlive()) {
            throw new Exception('Rate limiter requires enabled cache. Check Memcache connection.');
        }

        /** RateLimiter is ready to work */
        $this->isEnabled = true;
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
}