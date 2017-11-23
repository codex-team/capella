<?php

namespace API;

/**
 * Return data with right response headers
 */
class Response
{
    public static function json($responseData)
    {
        echo json_encode($responseData);
    }

    public static function success($data)
    {
        $response = array_merge(
            array(
                'success' => true
            ),
            $data
        );

        self::json($response);
    }

    public static function error($data)
    {
        $response = array_merge(
            array(
                'success' => false
            ),
            $data
        );

        self::json($response);
    }

    /**
     * Echo data to the page
     *
     * @param array $data
     *    $data['type'] string - mime-type
     *    $data['blob'] string - blob
     *    $data['length'] int - size
     */
    public static function data($data)
    {
        $blob   = $data['blob'];
        $type   = $data['type'];
        $length = $data['length'];

        if ($type) {
            header("Content-Type: $type");
        }

        if ($length) {
            header("Content-Length: $length");
        }

        echo $blob;
    }

}
