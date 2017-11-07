<?php

/**
 * Router
 */
$requestUri = explode('?', $_SERVER['REQUEST_URI'])[0];
$requestUri = trim($requestUri, '/');
$alias = explode('/', $requestUri)[0];

switch ($alias) {
    /**
     * Show main page
     */
    case '':
        require_once DOCROOT."src/view/index.php";
        break;

    /**
     * Uploader uri
     */
    case 'upload':
        new \Controller\Form();
        break;

    /**
     * Show success page
     */
    case 'file':
        require_once DOCROOT."src/view/file.php";
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
        }
        break;
}
