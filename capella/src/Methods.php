<?php

use Controller\Uploader;

class Methods
{
    /**
     * ID generator
     *
     * @return string generated ID
     */
    public static function generateId()
    {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    /**
     * Get image uri to Capella server
     *
     * @param string $id - image's id
     *
     * @return string image uri
     */
    public static function getImageUri($id)
    {
        $domain = self::getDomainAndProtocol();

        return $domain . "/" . $id;
    }

    /**
     * Return path to image source by id
     *
     * If you store images in a cloud then upgrade this function
     * for getting image's source from the cloud
     *
     * @param $id - image's id
     *
     * @return string
     *
     * @throws \Exception
     */
    public static function getPathToImageSource($id)
    {
        $imageUrl = 'upload/' . $id . '.' . Uploader::TARGET_EXT;

        if (!file_exists($imageUrl)) {
            throw new \Exception('File does not exist');
        }

        return $imageUrl;
    }

    /**
     * Get server domain name and protocol
     *
     * @return string $protocol.$domain
     */
    public static function getDomainAndProtocol()
    {
        if ( isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {

            $protocol = 'https://';

        } else {

            $protocol = 'http://';

        }

        $host = $_SERVER['HTTP_HOST'];

        return $protocol . $host;
    }

    /**
     * Check for AJAX request
     *
     * @return boolean
     */
    public static function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
    }

}
