<?php

class WrongFileSize extends Exception {}
class WrongFileType extends Exception {}

class Image {
    const MAX_FILE_SIZE = 15*1024*1024*8; #15 МБ
    const EXTENSIONS = array('image/jpg', 'image/png', 'image/jpeg', 'image/gif', 'jpg', 'png', 'jpeg', 'gif');

    protected $fileSize;
    protected $fileExp;
    protected $filePath;

    protected function checkExtension()
    {
        if (!in_array($this->fileExp, self::EXTENSIONS)) {
            throw new WrongFileType("Wrong file type.");
        }
    }

    protected function checkSize()
    {
        if ($this->fileSize > self::MAX_FILE_SIZE) {
            throw new WrongFileSize('The file is too big.');
        }
    }
}


class FileImage extends Image
{
    public function __construct($img)
    {
        if(isset($Img['type'])) {
            $this->fileExp = $img['type'];
        }
        if(isset($_FILES['ImageFile']['size'])) {
            $this->fileSize = $img['size'];
        }
        if(isset($_FILES['ImageFile']['tmp_name'])) {
            $this->filePath = $img['tmp_name'];
        }
    }

    public function upload()
    {
        $this->checkExtension();
        $this->checkSize();
        require_once 'lib/AWS/Storage.php';
        $storage = new AWS_Storage();
        $imgID = $storage->uploadImage($this->filePath);
        $imgURI = $storage->getImage($imgID);
        return $imgURI;
    }
}

class LinkImage extends Image
{
    private $fileName;

    public function __construct($url)
    {
        $this->fileName = basename($url['ImageLink']);
        $this->fileExp = explode('.', $url['ImageLink']);
        $this->fileExp = $this->fileExp[count($this->fileExp)-1];
        $this->fileSize = get_headers($url['ImageLink']);
        $this->fileSize = $this->fileSize['Content-Length'];
    }

    public function upload()
    {
        $this->checkExtension();
        $this->checkSize();
        file_put_contents($this->fileName, file_get_contents($_GET['ImageLink']));
        $this->filePath = realpath($this->fileName);
        require_once('lib/AWS/Storage.php');
        $storage = new AWS_Storage();
        $imgID = $storage->uploadImage($this->filePath);
        $imgURI = $storage->getImage($imgID);
        unlink($this->filePath);
        return $imgURI;
    }
}