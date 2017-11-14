<?php

namespace HTTP;


class Response
{
    public static function response($code, $status, $contentType='text/html')
    {
        header("HTTP/1.0 $code $status");
        header("HTTP/1.1 $code $status");
        header("Status: $code $status");
        header("Content-Type: $contentType");
    }

    public static function OK($contentType='text/html') {
        self::response(200, 'OK', $contentType);
    }

    public static function BadRequest($contentType='text/html')
    {
        self::response(400, 'Bad Request', $contentType);
    }

    public static function NotFound($contentType='text/html')
    {
        self::response(404, 'Not Found', $contentType);
    }

    public static function MethodNotAllowed($contentType='text/html')
    {
        self::response(405, 'Method Not Allowed', $contentType);
    }

    public static function InternalServerError($contentType='text/html')
    {
        self::response(500, 'Internal Server Error', $contentType);
    }

    /**
     * Echo data to the page
     *
     * @param array $imageData
     *    $imageData['type'] string - image mime-type
     *    $imageData['blob'] string - blob image
     *    $imageData['length'] int - image size
     */
    public static function data($imageData)
    {
        $blob = $imageData['blob'];
        $type = $imageData['type'];
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
