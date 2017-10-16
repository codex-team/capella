<?php

class wrongFileSize extends Exception {}
class wrongFileType extends Exception {}

class FileImage
{
    const MAX_FILE_SIZE = 15*1024*1024*8; #15 МБ
    const EXTENSIONS = array('image/jpg', 'image/png', 'image/jpeg', 'image/gif', 'jpg', 'png', 'jpeg', 'gif');

    private $fileSize;
    private $fileExp;
    private $filePath;

    public function __construct()
    {
        if(isset($_FILES['ImageFile']['type'])) {
            $this->fileExp = $_FILES['ImageFile']['type'];
        }
        if(isset($_FILES['ImageFile']['size'])) {
            $this->fileSize = $_FILES['ImageFile']['size'];
        }
        if(isset($_FILES['ImageFile']['tmp_name'])) {
            $this->filePath = $_FILES['ImageFile']['tmp_name'];
        }
    }

    private function checkExtension()
    {
        if (!in_array($this->fileExp, self::EXTENSIONS)) {
            throw new wrongFileType("Wrong file type.");
        }
    }

    private function checkSize()
    {
        if ($this->fileSize > self::MAX_FILE_SIZE) {
            throw new wrongFileSize('The file is too big.');
        }
    }

    public function upload()
    {
        try {
            $this->checkExtension();
        } catch (wrongFileType $e) {
            return $e->getMessage();
        }
        try {
            $this->checkSize();
        } catch (wrongFileSize $e) {
            return $e->getMessage();
        }
        require_once 'lib/AWS/Storage.php';
        $storage = new AWS_Storage();
        $imgID = $storage->uploadImage($this->filePath);
        $imgURI = $storage->getImage($imgID);
        return $imgURI;
    }
}