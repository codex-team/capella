<?php

/**
 * Router
 */
$requestUri = explode('?', $_SERVER['REQUEST_URI'])[0];

$alias = trim($requestUri, '/');

switch ($alias) {
    /**
     * Show main page
     */
    case '':
        require_once DOCROOT."src/view/index.php";
        break;

    /**
     * Show result page
     */
    case 'result':
        require_once DOCROOT."src/view/result.php";
        break;

    /**
     * Uploader uri
     */
    case 'upload':
        new \Controller\Form();
        break;

    
    /**
     * Process uri
     */
    default:
        try {

            $processing = new \Controller\Processing($requestUri);

        } catch (\Exception $e) {

            \Hawk\HawkCatcher::catchException($e);

            \HTTP\Response::InternalServerError();
            echo "Internal Server Error";
            die();

        }

        break;
}
