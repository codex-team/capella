<?php

namespace Controller;

use HTTP;

/**
 * Show Capella page with uploaded image
 */
class Image
{
    public function __construct($requestUri)
    {
        try {

            /** Get the image id from  request URI */
            $imageId = explode('/', $requestUri)[2];

            /** Check if image exist */
            \Methods::getPathToImageSource($imageId);

            /** Create a link to the image */
            $imageURL = \Methods::getImageUri($imageId);

            /** Render page */
            require_once DOCROOT . "src/view/result.php";
        } catch (\Exception $e) {
            HTTP\Response::NotFound();

            die();
        }
    }
}
