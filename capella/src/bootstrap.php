<?php defined('DOCROOT') or die('No direct script access.');

/**
 * Autoload vendor
 */
require_once DOCROOT . 'vendor/autoload.php';

/**
 * Load Dotenv
 *
 * @see https://github.com/vlucas/phpdotenv
 */
if (is_file(DOCROOT . '.env')) {
    $dotenv = new Dotenv\Dotenv(DOCROOT);
    $dotenv->load();
}

/**
 * Hawk PHP Catcher
 *
 * @link https://hawk.so/docs
 */
if (isset($_SERVER['HAWK_TOKEN'])) {
    \Hawk\HawkCatcher::instance($_SERVER['HAWK_TOKEN']);
    \Hawk\HawkCatcher::enableHandlers(
        false,  // exceptions
        true,       // errors
        true     // shutdown
    );
}

/**
 * Autoload classes
 */
require_once DOCROOT . 'src/autoload.php';

/**
 * Setup Capella access via GET param 'token'
 */
const TOKEN_COOKIE_NAME = 'token';
const COOKIE_LIFETIME = 2147483647;

if (isset($_GET[TOKEN_COOKIE_NAME])) {
    /**
     * Almost endless cookie lifetime is a max integer value
     * 2147483647 = 2^31 - 1
     */
    setcookie(TOKEN_COOKIE_NAME, $_GET[TOKEN_COOKIE_NAME], COOKIE_LIFETIME);
}

/**
 * Router
 */
require_once DOCROOT . 'src/router.php';
