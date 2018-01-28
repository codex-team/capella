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

        /**
         * The Expires entity-header field gives the date/time
         * after which the response is considered stale.
         *
         * https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.21
         */
        header('Expires: ' . $expiresTimestamp);

        /**
         * The Cache-Control general-header field is used to specify
         * directives that MUST be obeyed by all caching mechanisms
         * along the request/response chain.
         *
         * https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.9
         */
        header('Cache-Control: max-age=' . $secondsToCache);
    }

}
