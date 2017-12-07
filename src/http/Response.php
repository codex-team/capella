<?php

namespace HTTP;

/**
 * Set code and status headers for response
 */
class Response
{
    public static function response($code, $status)
    {
        header("HTTP/1.0 $code $status");
        header("HTTP/1.1 $code $status");
        header("Status: $code $status");

        $contentType = \Methods::isAjax() ? "application/json" : "text/html";

        header("Content-Type: $contentType");
    }

    public static function OK()
    {
        self::response(200, 'OK');
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
     * Set cache headers
     *
     * @param integer $secondsToCache — cache lifetime in seconds
     */
    public static function cache($secondsToCache = 3600)
    {
        $expiresTimestamp = gmdate('D, d M Y H:i:s', time() + $secondsToCache) . ' GMT';
        header('Expires: '.$expiresTimestamp);
        header('Pragma: cache');
        header('Cache-Control: max-age='.$secondsToCache);
    }

}
