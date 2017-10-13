<?php

class ImageProcessing
{
    private $validExtensions = array('png', 'gif', 'jpeg');
    public $imageExtension;
    public $height, $width;
    public $imagePath = null;

    public $imagick;
	
    function __construct()
    {
        $this->imagick = new Imagick();
    }

    /**
     *
     * @param {String} $extension we want to valid
     * @return bool
     */
    private function isValidExtension($extension)
    {
        $extension = strtolower($extension);
        foreach ($this->validExtensions as $value){
            if($value == $extension){
                return true;
			}
		}
        return false;
    }

    /**
     * @param {String} $path path to image
     * @throws Exception
     */
    function readImage($path)
    {
        if((@$this->imagick ->readImage($path)) == false){
            throw new Exception("Invalid image path.");
        }
        $this->imageExtension = $this->imagick ->getImageFormat();
        if(!$this->isValidExtension($this->imageExtension)) {
            throw new Exception("Unsupported Extension");
        }
    }

    /**
     * @param {int} $x start crop position
     * @param {int} $y start crop position
     * @param {int} $cropWidth
     * @param {int} $cropHeight
     */
    function cropImage($x, $y, $cropWidth, $cropHeight)
    {
        $this->imagick->cropImage($cropWidth, $cropHeight, $x, $y);
    }

    /**
     * @param {int} $resizeWidth
     * @param {int} $resizeHeight
     * @param {int} $filter Refer to the list of filter constants
     * @param {int} $blur The blur factor where > 1 is blurry, < 1 is sharp.
     * @param {bool} $fit
     */
    function resizeImage($resizeWidth,$resizeHeight,$filter,$blur,$fit = false)
    {
        $this->imagick->resizeImage($resizeWidth, $resizeHeight, $filter, $blur, $fit);
    }

    /**
     * output image in browser
     */
    function echoImage()
    {
        header('Content-Type: image/'.$this->imageExtension);
        echo $this->imagick->getImageBlob();
    }
}
?>