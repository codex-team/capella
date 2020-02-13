<?php


use Cache\Cache;

/**
 * @singleton
 *
 * Simple rate limiter module powered by memcache
 *
 */

class RateLimiter
{
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

    public function check($key, $quota = false, $cycle = false)
    {
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

        /** Is Cache available */
        $cache = \Cache\Cache::instance();
        if (!$cache->isAlive()) {
            throw new Exception('Rate limiter requires enabled cache. Check Memcache connection.');
        }
    }

}