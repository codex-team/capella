<?php

/**
 * Router
 */
$requestUri = explode('?', $_SERVER['REQUEST_URI'])[0];

/**
 * array(3) {
 *     [0]=> string(0) ""
 *     [1]=> string(5) "image"
 *     [2]=> string(36) "26334101-838a-4c34-9317-c90f4217370e"
 * }
 */
$alias = explode('/', $requestUri)[1];


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
    case 'image':
        new \Controller\Image($requestUri);
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
