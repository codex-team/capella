<?php

class ImageProcessing
{
    public $validExtensions = array('png','gif','jpeg');
    public $imageExtension;
    public $height,$width;
    public $imagePath = null;

    public $imagick;
	
    function __construct()
    {
        $this->imagick = new Imagick();
    }

    function __destruct()
    {
        $this->imagick = null;
    }
	
    /**
     *
     * @param $extension extension which we want to valid
     * @return bool
     */
    function isValidExtension($extension)
    {
        $extension = strtolower($extension);
        for($i=0;$i<count($this->validExtensions);$i++)
            if($this->validExtensions[$i] == $extension)
                return true;
        return false;
    }

    /**
     * @param $path path to image
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
     * @param $x start crop position
     * @param $y start crop position
     * @param $cropWidth
     * @param $cropHeight
     */
    function cropImage($x,$y,$cropWidth,$cropHeight)
    {
        $this->imagick->cropImage($cropWidth,$cropHeight,$x,$y);
    }

    /**
     * @param $resizeWidth
     * @param $resizeHeight
     * @param $filter Refer to the list of filter constants
     * @param $blur The blur factor where > 1 is blurry, < 1 is sharp.
     * @param $fit
     */
    function resizeImage($resizeWidth,$resizeHeight,$filter,$blur,$fit = false)
    {
        $this->imagick->resizeImage($resizeWidth,$resizeHeight,$filter,$blur,$fit);
    }

    /**
     * output image in browser
     */
    function echoImage()
    {
        header('Content-Type: image');
        echo $this->imagick->getImageBlob();
    }
	
    /**
     * create random string with $characters alphabet
     * @param int $length
     * @return string
     */
    function generateRandomName($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

?>