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
     * @param string $id - image's id
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

    /**
     * Get request source IP address
     *
     * @return string
     */
    public static function getRequestSourceIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    /**
     * Get correct word for single or plural items
     *
     * @param integer $num - number of items
     * @param string $nominative - word for 1 item
     * @param string $genitive_singular - word for 4 items
     * @param string $genitive_plural - word for 5 items
     *
     * @return string
     */
    public static function getNumEnding($num, $nominative, $genitive_singular, $genitive_plural)
    {
        if ($num > 10 && (floor(($num % 100) / 10)) == 1) {
            return $genitive_plural;
        } else {
            switch ($num % 10) {
                case 1: return $nominative;
                case 2: case 3: case 4: return $genitive_singular;
                case 5: case 6: case 7: case 8: case 9: case 0: return $genitive_plural;
            }
        }
    }
}
