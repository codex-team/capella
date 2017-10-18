<?php

namespace HTTP;


class Response
{

    public static function NotFound() {

        self::response(404, 'Not Found');

    }

    public static function InternalServerError() {

        self::response(500, 'Internal Server Error');

    }

    private static function response($code, $status) {

        header("HTTP/1.0 $code $status");
        header("HTTP/1.1 $code $status");
        header("Status: $code $status");
        die();

    }

}