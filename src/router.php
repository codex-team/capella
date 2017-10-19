<?php

/**
 * Router
 */
$requestUri = explode('?', $_SERVER['REQUEST_URI'])[0];

if (trim($requestUri, '/') == '') {

    /** Main page */
    require_once DOCROOT."src/form.php";

} else {

    try {
        $processing = new \Controller\Processing($requestUri);
    } catch (Exception $e) {
        echo $e;
        \HTTP\Response::InternalServerError();
    }

}
