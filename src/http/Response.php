<?php

namespace HTTP;


class Response
{
    private static function response($code, $status)
    {
        header("HTTP/1.0 $code $status");
        header("HTTP/1.1 $code $status");
        header("Status: $code $status");

        echo $status;

        die();
    }

    public static function BadRequest()
    {
        self::response(400, 'Bad Request');
    }

    public static function NotFound()
    {
        self::response(404, 'Not Found');
    }

    public static function MethodNotAllowed()
    {
        self::response(405, 'Method Not Allowed');
    }

    public static function InternalServerError()
    {
        self::response(500, 'Internal Server Error');
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
