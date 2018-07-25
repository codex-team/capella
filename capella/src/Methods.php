<?php

class Methods
{
    /**
     * ID generator
     *
     * @return string generated ID
     */
    public static function generateId()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
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

        return $domain . "/" . $id . "." . Uploader::TARGET_EXT;
    }

    /**
     * Get image's id from name
     *
     * 52df7fbf-ff1d-44e7-803a-e9f04d03d542.jpg
     *   -> 52df7fbf-ff1d-44e7-803a-e9f04d03d542
     *
     * @param string $name
     * @return string
     */
    public static function imageNameToId($name)
    {
        $defaultExtension = Uploader::TARGET_EXT;

        /**
         * Allow getting images with extension at the end of uri
         */
        if (preg_match('/(?P<id>[\w-]+)\.'.$defaultExtension.'$/', $name, $matches)) {
            return $matches['id'];
        }

        return $name;
    }

    /**
     * Return path to image source by id
     *
     * If you store images in a cloud then upgrade this function
     * for getting image's source from the cloud
     *
     * @param $id - image's id
     *
     * @throws \Exception
     *
     * @return string
     *
     */
    public static function getPathToImageSource($id)
    {
        $imageUrl = 'upload/' . $id . '.' . \Uploader::TARGET_EXT;

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
        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
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
     * @return bool
     */
    public static function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
    }
}
