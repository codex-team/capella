<?php

namespace App;

/**
 * Class ImageProcessing
 *
 * @example create new class with image from path in constructor
 * $image = new ImageProcessing("C:/Users/image.png");
 * @example use filters
 * $image->resizeImage(400,300);
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

    private $validExtensions = ['png', 'gif', 'jpeg'];

    /**
     * ImageProcessing constructor
     *
     * @param string $path - local path to image
     *
     * @throws \Exception
     */
    public function __construct($path)
    {
        $this->imagick = new \Imagick();
        $this->readImage($path);

        /** Fix image's orientation */
        $this->autoRotateImage();

        /** Remove all additional image's data */
        $this->imagick->stripImage();
    }

    /**
     * Crop image by dimensions with coordinates
     *
     * @example crop image with coordinates
     * $image->cropImage(100,100,0,10);
     * @example crop image by center coordinate
     * $image->cropImage(200,150);
     * $image->cropImage(100);
     *
     * @param int      $cropWidth
     * @param int      $cropHeight
     * @param int|null $x          - crop x
     * @param int|null $y          - crop y
     *
     * @throws \Exception
     */
    public function cropImage($cropWidth, $cropHeight = null, $x = null, $y = null)
    {
        if ($cropWidth == null && $cropHeight == null) {
            throw new \Exception("Incorrect input dimensions");
        }

        if ($cropWidth == null) {
            $cropWidth = $cropHeight;
        } elseif ($cropHeight == null) {
            $cropHeight = $cropWidth;
        }

        if ($x == null || $y == null) {
            $ratio = max($cropHeight / $this->height, $cropWidth / $this->width);

            $this->imagick->scaleImage($ratio * $this->width, $ratio * $this->height);

            $this->recalculateDimensions();

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
     * @example resize image by height and width
     * $image->resizeImage(400,300);
     * $image->resizeImage(100);
     *
     * @param int $resizeWidth
     * @param int $resizeHeight
     *
     * @throws \Exception
     */
    public function resizeImage($resizeWidth, $resizeHeight = 0)
    {
        if (!$resizeWidth && !$resizeHeight) {
            throw new \Exception('Incorrect input dimensions');
        }

        if ($resizeWidth == 0) {
            $this->imagick->scaleImage(0, $resizeHeight);
        } elseif ($resizeHeight == 0) {
            $this->imagick->scaleImage($resizeWidth, 0);
        } else {
            $ratio = min($resizeHeight / $this->height, $resizeWidth / $this->width);

            $this->imagick->scaleImage($ratio * $this->width, $ratio * $this->height);
        }

        $this->recalculateDimensions();
    }

    /**
     * Pixelize image
     *
     * @example pixelize image by pixels count
     * $image->pixelizeImage(15);
     *
     * @param int $pixels
     *
     * @throws \Exception
     */
    public function pixelizeImage($pixels)
    {
        if (!$pixels) {
            throw new \Exception('Incorrect ratio');
        }

        if ($this->width > $this->height) {
            $ratio = $this->width / $pixels;
            $this->resizeImage($this->width / $ratio, 0);
            $this->resizeImage($this->width * $ratio, 0);
        } else {
            $ratio = $this->height / $pixels;
            $this->resizeImage(0, $this->height / $ratio);
            $this->resizeImage(0, $this->height * $ratio);
        }
    }

    /**
     * Add a cover for target image
     *
     * @param string $color         - hex code of cover's color without hash symbol. Ex: eff2f5
     * @param int    $width         - width of cover for image
     * @param float  $maxWidthRatio - max part of cover's width to stretch image
     * @param int    $margin        - number pof pixels up and down image on cover
     *
     * @throws \Exception|\ImagickException
     */
    public function addCover($color, $width = 1000, $maxWidthRatio = 0.6, $margin = 10)
    {
        /**
         * Check for color validness
         * - Color must be a hexadecimal digit
         * - 3 or 6 symbols string length
         */
        $isValidColor = ctype_xdigit($color) && (strlen($color) == 6 || strlen($color) == 3);

        if (!$isValidColor) {
            throw new \Exception("Color must be in a hex format without hash symbol");
        }

        /**
         * Count max image's width to be placed onto cover
         */
        $maxImageWidth = $width * $maxWidthRatio;

        /**
         * Resize image if it is wider than target part of cover's width
         */
        if ($this->width > $maxImageWidth) {
            $this->resizeImage($maxImageWidth);
        }

        /**
         * Count cover's height
         *
         * •-------------------------•  -
         * | cover                   |  | margin
         * |      •-----------•      |  -
         * |      |           |      |  |
         * |      |   image   |      |  | image's height
         * |      |           |      |  |
         * |      •-----------•      |  -
         * |                         |  | margin
         * •-------------------------•  -
         *        |-----------|
         *         image's width is not more
         *         than the 60% of cover's width
         */
        $coverHeight = $margin * 2 + $this->height;

        /**
         * Create a new image as a cover
         */
        $cover = new \Imagick();
        $cover->newImage($width, $coverHeight, new \ImagickPixel('#' . $color));
        $cover->setImageFormat('png');

        /**
         * Count image's position
         */
        $imagePosition = [
            'x' => $width / 2 - $this->width / 2,
            'y' => $margin
        ];

        /**
         * Compose cover and image
         */
        $cover->compositeImage($this->imagick, \Imagick::COMPOSITE_IN, $imagePosition['x'], $imagePosition['y']);

        /**
         * Save composed image as a processed image
         */
        $this->imagick = $cover;

        /**
         * Update dimensions
         */
        $this->recalculateDimensions();
    }

    /**
     * Get image blob
     *
     * @return string - blob image
     */
    public function getImageBlob()
    {
        return $this->imagick->getImageBlob();
    }

    /**
     * Defines available image formats
     *
     * @param string $extension - ext we want to check
     *
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
     * @param string $path - local path to image
     *
     * @throws \Exception
     */
    private function readImage($path)
    {
        $this->path = $path;

        try {
            $readResult = @$this->imagick->readImage($path);
        } catch (\Exception $e) {
            HTTP\Response::NotFound();

            die();
        }

        $this->extension = $this->imagick->getImageFormat();
        if (!$this->isValidExtension($this->extension)) {
            throw new \Exception("Unsupported Extension");
        }

        $this->recalculateDimensions();
    }

    /**
     * Rotate image right by orientation's params
     */
    private function autoRotateImage()
    {
        $orientation = $this->imagick->getImageOrientation();

        switch ($orientation) {
            /** rotate 180 degrees */
            case \Imagick::ORIENTATION_BOTTOMRIGHT:
                $this->imagick->rotateimage("#000", 180);
                break;

            /** rotate 90 degrees CW */
            case \Imagick::ORIENTATION_RIGHTTOP:
                $this->imagick->rotateimage("#000", 90);
                break;

            /** rotate 90 degrees CCW */
            case \Imagick::ORIENTATION_LEFTBOTTOM:
                $this->imagick->rotateimage("#000", -90);
                break;
        }

        /** Save image's orientation */
        $this->imagick->setImageOrientation(\Imagick::ORIENTATION_TOPLEFT);
    }
}
