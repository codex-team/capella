<?php

use DB\DbNames;
use DB\Mongo;

/**
 * Parent class, which describes acceptable extension,
 * file size and methods that check these parameters.
 */
class Uploader
{
    /**
     * Max size for files in bytes
     *
     * @var int
     */
    const MAX_FILE_SIZE = 15 * 1024 * 1024;

    /**
     * Acceptable MIME-types
     *
     * @var array
     */
    const MIME_TYPES = [
        'image/jpg',
        'image/png',
        'image/jpeg',
        'image/gif',
        'image/bmp',
        'image/tiff'
    ];

    /**
     * Extension for saved files
     *
     * @var string
     */
    const TARGET_EXT = 'jpg';

    /**
     * Temp files directory
     *
     * @var string
     */
    const UPLOAD_DIR = 'upload/';

    /**
     * Project's dentifier of image target
     *
     * @var string
     */
    var $projectId = '';

    /**
     * Check uploads dir, prepare project's ID
     *
     * @param string $projectId
     */
    public function __construct($projectId)
    {
        if (!file_exists(self::UPLOAD_DIR) || !is_writable(self::UPLOAD_DIR)) {
            $errorMessage = self::UPLOAD_DIR . ' directory should be writable';

            trigger_error($errorMessage, E_USER_ERROR);
            error_log($errorMessage);

            \HTTP\Response::InternalServerError();

            \API\Response::error([
                'message' => 'Internal Server Error'
            ]);
        }

        $this->projectId = $projectId;
    }

    /**
     * Check extension
     *
     * @param string $mime
     *
     * @return bool
     */
    protected function isValidMimeType($mime)
    {
        return in_array($mime, self::MIME_TYPES);
    }

    /**
     * Check file size
     *
     * @param $size
     *
     * @return bool
     */
    protected function isValidSize($size)
    {
        return (int) $size <= self::MAX_FILE_SIZE;
    }

    /**
     * Save file to uploads dir
     *
     * @param string $filepath - path to the file or url
     *
     * @throws \Exception
     *
     * @return array - saved file data
     *
     */
    protected function saveFileToUploadDir($filepath)
    {
        /** Get file hash */
        $hash = hash_file('sha256', $filepath);

        /** Check for a saved copy */
        $isAlreadySaved = $this->findDuplicateByHash($hash);

        if ($isAlreadySaved) {
            return $isAlreadySaved;
        }

        /** Generate filename */
        $path = Uploader::UPLOAD_DIR . \Methods::generateId() . "." . self::TARGET_EXT;

        /** Save file to uploads dir */
        file_put_contents($path, file_get_contents($filepath));

        /** Get MIME-type from file */
        $mimeType = mime_content_type($path);

        if (!$this->isValidMimeType($mimeType)) {
            unlink($path);
            throw new \Exception('Wrong source mime-type: ' . $mimeType);
        }

        /** Get uploaded image */
        $image = new Imagick($path);

        /** Add white background */
        $image->setImageBackgroundColor(new ImagickPixel('white'));
        $image = $image->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);

        /** Convert image to jpg */
        $image->setImageFormat(self::TARGET_EXT);
        $image->setImageCompressionQuality(90);
        $image->writeImage($path);

        /** Save image resolution */
        $width = $image->getImageWidth();
        $height = $image->getImageHeight();

        /** Get image size in bytes */
        $imageSize = strlen($image->getImageBlob());

        /**
         * Finding main color
         * 1) resize to 1x1 image with gaussian blur
         * 2) get color of top left pixel
         * 3) convert color from rgb to hex
         */
        $image->resizeImage(1, 1, Imagick::FILTER_GAUSSIAN, 1);
        $color = $image->getImagePixelColor(1, 1)->getColor();
        $colorHex = sprintf("#%02x%02x%02x", $color['r'], $color['g'], $color['b']);

        $imageData = [
            'author' => $this->getAuthor(),
            'filepath' => $path,
            'width' => $width,
            'height' => $height,
            'color' => $colorHex,
            'mime' => 'image/' . self::TARGET_EXT,
            'size' => $imageSize,
            'hash' => $hash,
            'projectId' => $this->projectId
        ];

        /** Save image data to DB */
        Mongo::connect()->{DbNames::IMAGES}->insertOne($imageData);

        return $imageData;
    }

    /**
     * Return request source IP address
     *
     * @return string
     */
    protected function getAuthor() {
        return Methods::getRequestSourceIp();
    }

    /**
     * Try to find already saved image by hash
     *
     * @param string $hash
     */
    protected function findDuplicateByHash($hash)
    {
        /** Check for a hash existing */
        $mongoResponse = Mongo::connect()->{DbNames::IMAGES}->findOne([
            'hash' => $hash
        ]);

        if (!!$mongoResponse) {
            /* File already exist */
            return $mongoResponse;
        }

        return false;
    }

    /**
     * Wrapper for saving image. Returns image's URL.
     *
     * Upgrade this function if you need to upload image
     * to a cloud or insert data to DB.
     * Also upgrade function \Methods::getPathToImageSource()
     * to set up getting image source.
     *
     * @param $file - temp file
     *
     * @throws \Exception
     *
     * @return array - image data
     *
     */
    protected function saveImage($file)
    {
        /** Copy temp file to upload dir */
        $imageData = $this->saveFileToUploadDir($file);
        $label = explode('.', basename($imageData['filepath']))[0];

        /** Get image's URL by id */
        $imageData['link'] = \Methods::getImageUri($label);

        return $imageData;
    }

    /**
     * Check and upload image
     *
     * @param string $file - path to image
     * @param string $size - image size
     * @param string $mime - image mime-type
     *
     * @throws \Exception
     *
     * @return array - uploaded image data
     *
     */
    protected function upload($file, $size, $mime)
    {
        if (!$file || !$size || !$mime) {
            throw new \Exception('Source is damaged');
        }

        if (!$this->isValidSize($size)) {
            throw new \Exception('Source is too big');
        }

        if (!$this->isValidMimeType($mime)) {
            throw new \Exception('Wrong source mime-type: ' . $mime);
        }

        /** Upload file and get its ID */
        $imageData = $this->saveImage($file);

        return $imageData;
    }

    /**
     * Public function for file uploading via POST form-data
     *
     * @param array $data - image file from $_FILES
     *
     * @throws \Exception
     *
     * @return array - uploaded image data
     *
     */
    public function uploadFile($data)
    {
        if (!is_uploaded_file($data['tmp_name'])) {
            throw new \Exception('File is missing');
        }

        $mime = mime_content_type($data['tmp_name']);

        return $this->upload($data['tmp_name'], $data['size'], $mime);
    }

    /**
     * Public function for uploading image by url
     *
     * @param {string} $url - path to image
     *
     * @throws \Exception
     *
     * @return array - uploaded image data
     *
     */
    public function uploadLink($url)
    {
        /** Get link info */
        $headers = @get_headers($url, 1);

        if (!$headers) {
            throw new \Exception('Can\'t get headers for this URL');
        }

        $size = $headers['Content-Length'];
        $mime = $headers['Content-Type'];

        return $this->upload($url, $size, $mime);
    }
}
