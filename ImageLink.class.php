<?php

require_once 'FileImage.class.php';

class LinkImage
{

    private $fileSize;
    private $fileExp;
    private $fileName;
    private $filePath;


    public function __construct()
    {
        $this->fileName = basename($_GET['ImageLink']);
        $this->fileExp = explode('.', $_GET['ImageLink']);
        $this->fileExp = $this->fileExp[count($this->fileExp)-1];
        $this->fileSize = get_headers($_GET['ImageLink']);
        $this->fileSize = $this->fileSize['Content-Length'];
    }

    private function checkExtension()
    {
        if (!in_array($this->fileExp, FileImage::EXTENSIONS)) {
            throw new wrongFileType("Wrong file type.");
        }
    }

    private function checkSize()
    {
        if($this->fileSize > FileImage::MAX_FILE_SIZE) {
            throw new wrongFileSize('The file is too big');
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
        file_put_contents($this->fileName, file_get_contents($_GET['ImageLink']));
        $this->filePath = realpath($this->fileName);
        require_once('lib/AWS/Storage.php');
        $storage = new AWS_Storage();
        $imgID = $storage->uploadImage($this->filePath);
        $imgURI = $storage->getImage($imgID);
        return $imgURI;
    }
}