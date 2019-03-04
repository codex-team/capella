<?php defined('DOCROOT') or die('No direct script access.');

/**
 * Autoload vendor
 */
require_once DOCROOT . 'vendor/autoload.php';

/**
 * Set default timezone
 */
date_default_timezone_set('Europe/Moscow');

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
 * Router
 */
require_once DOCROOT . 'src/router.php';
