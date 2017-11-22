<?php

namespace API;

/**
 * Return data with right response headers
 */
class Response
{
    public static function returnJSON($responseData)
    {
        echo json_encode($responseData);
    }

    public static function OK($responseData = array())
    {
        \HTTP\Response::OK();

        self::returnJSON($responseData);
    }

    public static function BadRequest($responseData = array())
    {
        \HTTP\Response::BadRequest();

        self::returnJSON($responseData);
    }

    public static function MethodNotAllowed($responseData = array())
    {
        \HTTP\Response::MethodNotAllowed();

        self::returnJSON($responseData);
    }

    /**
     * Echo data to the page
     *
     * @param array $imageData
     *    $imageData['type'] string - image mime-type
     *    $imageData['blob'] string - blob image
     *    $imageData['length'] int - image size
     */
    public static function showData($imageData)
    {
        $blob   = $imageData['blob'];
        $type   = $imageData['type'];
        $length = $imageData['length'];

        if ($type) {
            header("Content-Type: $type");
        }

        if ($length) {
            header("Content-Length: $length");
        }

        echo $blob;
    }

}
