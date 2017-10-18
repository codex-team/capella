<?php

/** Autoload vendor */
require_once "vendor/autoload.php";

/** Autoload classes */
require_once "lib/autoload.php";


/**
 * Router
 */
$requestUri = explode('?', $_SERVER['REQUEST_URI'])[0];

if (trim($requestUri, '/') == '') {

    /** Main page */
    require_once "uploaderForm.php";

} else {

    try {
        $processing = new \Controller\Processing($requestUri);
    } catch (Exception $e) {
        \HTTP\Response::InternalServerError();
    }

}

?>
