<?php

namespace Controller;

/**
 * Class for processing uploading form or AJAX upload
 */
class Image
{
    public function __construct($requestUri) {

        try {

            /** Get the image id from  request URI */
            $imageId = explode('/', $requestUri)[2];

            /** Create a link to the image */
            $imageURL = \Methods::getImageUri($imageId);

            /** Render page */
            require_once DOCROOT."src/view/result.php";

        } catch (\Exception $e) {

            \HTTP\Response::NotFound();

            die();

        }

    }

}
