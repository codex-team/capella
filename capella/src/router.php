<?php

namespace App;

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
        require_once DOCROOT . "src/View/index.php";
        break;

    /**
     * Show result page
     */
    case 'image':
        new Controller\Image($requestUri);
        break;

    /**
     * Uploader uri
     */
    case 'upload':
        new Controller\Form();
        break;

    /**
     * Apply new project form
     */
    case 'project':
        if (Env::getBool('PROJECT_REGISTRATION_IS_AVAILABLE')) {
            new Controller\Project();
        } else {
            HTTP\Response::Forbidden();

            API\Response::text("Project registration is not available.");
        }
        break;

    /**
     * Process uri
     */
    default:
        try {
            $processing = new Controller\Processing($requestUri);
        } catch (\Exception $e) {
            \Hawk\HawkCatcher::catchException($e);

            HTTP\Response::InternalServerError();

            API\Response::text("Internal Server Error");
        }
}
