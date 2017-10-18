<?php

require_once "vendor/autoload.php";

require_once "lib/autoload.php";

$requestUri = explode('?', $_SERVER['REQUEST_URI'])[0];

if (trim($requestUri, '/') == '') {
    /**
     * Main page
     */
    require_once "uploaderForm.php";

} else {

    try {
        $processing = new \Controller\Processing($requestUri);
    } catch (Exception $e) {
        \HTTP\Response::InternalServerError();
    }

}

?>
