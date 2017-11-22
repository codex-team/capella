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

    public static function returnSuccess($data)
    {
        $response = array(
            'success' => true
        );

        foreach ($data as $key => $value) {
            $response[$key] = $value;
        }

        self::returnJSON($response);
    }

    public static function returnError($data)
    {
        $response = array(
            'success' => false
        );

        foreach ($data as $key => $value) {
            $response[$key] = $value;
        }

        self::returnJSON($response);
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
