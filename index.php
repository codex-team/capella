<?php

/**
 * Set the full path to the docroot
 */
define('DOCROOT', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

/**
 * Bootstrap the application
 */
require DOCROOT.'src/bootstrap.php';
