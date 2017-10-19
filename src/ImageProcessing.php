<?php

/**
 * Class ImageProcessing
 *
 * @example create new class with image from path in constructor
 * $image = new ImageProcessing("C:/Users/image.png");
 *
 * @example crop image with coordinates
 * $image->cropImage(100,100,0,10);
 *
 * @example crop image by center coordinate
 * $image->cropImage(100,100);
 *
 * @example resize image by height and width
 * $image->resizeImage(100,null);
 * $image->resizeImage(null,100);
 * $image->resizeImage(100,100);
 *
 * @example getImageBlob returns the image sequence as a blob
 * $image->getImageBlob();
 */

class ImageProcessing
{
    public $extension;
    public $height;
    public $width;
    public $path = null;

    private $imagick;

    private $validExtensions = array('png', 'gif', 'jpeg');

    /**
     * ImageProcessing constructor
     *
     * @param $path local path to image
     */
    public function __construct($path)
    {
        $this->imagick = new Imagick();
        $this->readImage($path);
    }

    /**
     * Crop image by dimensions with coordinates
     *
     * @param {int} $cropWidth
     * @param {int} $cropHeight
     * @param {int} null $x crop x
     * @param {int} null $y crop y
     */
    public function cropImage($cropWidth, $cropHeight, $x = null, $y = null)
    {
        if ($cropWidth == null || $cropHeight== null) {
            throw new Exception("Uncorrected input dimensions");
        }

        if ($x == null || $y == null) {

            $x = $this->width / 2 - $cropWidth / 2;
            $y = $this->height / 2 - $cropHeight / 2;

            $this->imagick->cropImage($cropWidth, $cropHeight, $x, $y);

        } else {

            $this->imagick->cropImage($cropWidth, $cropHeight, $x, $y);

        }

        $this->recalculateDimensions();
    }

    /**
     * Resize image with dimensions
     *
     * @param {int} $resizeWidth
     * @param {int} $resizeHeight
     *
     * @throws Exception
     */
    public function resizeImage($resizeWidth, $resizeHeight)
    {
        if (!$resizeWidth && !$resizeHeight) {
            throw new Exception('Uncorrected input dimensions');
        }

        $ratioHeight = $resizeHeight ? $resizeHeight / $this->height : 1;
        $ratioWidth  = $resizeWidth  ? $resizeWidth  / $this->width  : 1;

        // Resize by the smallest ratio
        if ($ratioHeight > $ratioWidth) {

            $this->imagick->scaleImage($this->width * $ratioWidth, 0);

        } else {

            $this->imagick->scaleImage(0, $this->height * $ratioHeight);

        }

        $this->recalculateDimensions();
    }

    /**
     * Get image blob
     *
     * @return {string} blob image
     */
    public function getImageBlob()
    {
        return $this->imagick->getImageBlob();
    }

    /**
     * Defines available image formats
     *
     * @param {String} $extension we want to validate
     * @return bool
     */
    private function isValidExtension($extension)
    {
        $extension = strtolower($extension);

        return in_array($extension, $this->validExtensions);
    }

    /**
     * Calculate image dimensions
     */
    private function recalculateDimensions()
    {
        $this->width = $this->imagick->getImageWidth();
        $this->height = $this->imagick->getImageHeight();
    }

    /**
     * Read image from local path
     *
     * @param {String} $path local path to image
     * @throws Exception
     */
    private function readImage($path)
    {
        $this->path = $path;

        $readResult = @$this->imagick->readImage($path);
        if (!$readResult) {
            throw new Exception("Invalid image path");
        }

        $this->extension = $this->imagick->getImageFormat();
        if (!$this->isValidExtension($this->extension)) {
            throw new Exception("Unsupported Extension");
        }

        $this->recalculateDimensions();
    }
}
