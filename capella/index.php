<?php

/**
 * Set the full path to the docroot
 */
define('DOCROOT', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

/**
 * Load the installation check
 */
if (file_exists('install.php'))
{
    return include 'install.php';
}

/**
 * Bootstrap the application
 */
require DOCROOT.'src/bootstrap.php';
