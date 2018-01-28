<?php

namespace API;

/**
 * Return data with right response headers
 */
class Response
{
    /**
     * Return json encoded data
     *
     * @param {mixed} $responseData
     */
    public static function json($responseData)
    {
        echo json_encode($responseData);
    }

    /**
     * Return json encoded data with success = true
     *
     * @param {array} $data
     */
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

    /**
     * Return json encoded data with success = false
     *
     * @param {array} $data
     */
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
     * @param string $data - blob image
     * @param integer $cacheLifetime - set cache lifetime in seconds
     */
    public static function data($data, $cacheLifetime = 2 * 24 * 60 * 60)
    {
        $blob = $data;
        $type = 'image/jpeg';
        $length = strlen($blob);

        if ($type) {
            header("Content-Type: $type");
        }

        if ($length) {
            header("Content-Length: $length");
        }

        if ($cacheLifetime) {
            \HTTP\Response::cache($cacheLifetime);
        }

        echo $blob;
    }

}
