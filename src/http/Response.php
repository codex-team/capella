<?php

namespace HTTP;


class Response
{
    private static function response($code, $status)
    {
        header("HTTP/1.0 $code $status");
        header("HTTP/1.1 $code $status");
        header("Status: $code $status");

        if (\Methods::isAjax()) {

            echo json_encode(array(
                'code' => $code,
                'status' => $status
            ));

        } else {

            echo $status;

        }

        die();
    }

    public static function BadRequest($status = 'Bad Request')
    {
        self::response(400, $status);
    }

    public static function NotFound($status = 'Not Found')
    {
        self::response(404, $status);
    }

    public static function MethodNotAllowed($status = 'Method Not Allowed')
    {
        self::response(405, $status);
    }

    public static function InternalServerError($status = 'Internal Server Error')
    {
        self::response(500, $status);
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

    /**
     * Show AJAX response
     *
     * @param array $data
     * @return string json encoded data
     */
    public static function ajax($data)
    {
        echo json_encode(array(
          'code' => '200',
          'data' => $data
        ));
    }
}
