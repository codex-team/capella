<?php
require_once('../AWS/Storage.php');

class WrongFileSize extends Exception {}

class WrongFileType extends Exception {}

class AccessDenied extends Exception {}

/**
 * Parent class, witch describes acceptable extension, file size and methods that check these parameters.
 */
class Uploader {

    const MAX_FILE_SIZE = 15*1024*1024*8; #15 МБ
    const EXTENSIONS = array(   #Acceptable MIME-types
        'image/jpg',
        'image/png',
        'image/jpeg',
        'image/gif'
    );

    protected $fileSize;
    protected $fileExt;
    protected $filePath;

    protected function checkExtension() #Cheks extension
    {
        if (!in_array($this->fileExt, self::EXTENSIONS)) {
            throw new WrongFileType("Wrong file type.");
        }
    }

    protected function checkSize()  #Cheks file size
    {
        if ($this->fileSize > self::MAX_FILE_SIZE) {
            throw new WrongFileSize('The file is too big.');
        }
    }
}

/**
 * Class to work with a file
 *
 * Example usage:
 * try {
 *     $NewFile = new FileUploader($_FILES['ImageFile']);
 *     $NewFile->upload();
 * } catch (AccessDenied $e) {
 *     echo $e->getMessage();
 * } catch (WrongFileType $e) {
 *     echo $e->getMessage();
 * } catch (WrongFileSize $e) {
 *     echo $e->getMessage();
 * }
 */
class FileUploader extends Uploader
{
    public function __construct($img)
    {
        if (!is_uploaded_file($img['tmp_name'])) {
            throw new AccessDenied("Access denied. File wasn't uploaded");
        }

        if (isset($img['type'])) {
            $this->fileExt = mime_content_type($img['tmp_name']);
        }
        if (isset($_FILES['ImageFile']['size'])) {
            $this->fileSize = $img['size'];
        }
        if (isset($_FILES['ImageFile']['tmp_name'])) {
            $this->filePath = $img['tmp_name'];
        }
    }

    public function upload()
    {
        $this->checkExtension();    #Checking
        $this->checkSize();

        $storage = new AWS_Storage();   #Uploading to cloud
        $imgID = $storage->uploadImage($this->filePath);
        $imgURI = $storage->getImage($imgID);
        return $imgURI;
    }
}

/**
 * Class to work with a link
 *
 * Example usage:
 *$NewFile = new LinkUploader($_GET['ImageLink']);
 * try {
 *     $NewFile->upload();
 * } catch (WrongFileType $e) {
 *     echo $e->getMessage();
 * } catch (WrongFileSize $e) {
 *     echo $e->getMessage();
 * }
 */
class LinkUploader extends Uploader
{
    private $fileName;

    public function __construct($url)
    {
        $this->fileName = basename($url['ImageLink']);
        $this->fileExt = mime_content_type($url);
        $this->fileSize = get_headers($url['ImageLink']);
        $this->fileSize = $this->fileSize['Content-Length'];
    }

    public function upload()
    {
        $this->checkExtension(); #Checking
        $this->checkSize();

        file_put_contents($this->fileName, file_get_contents($_GET['ImageLink'])); #Saving file
        $this->filePath = realpath($this->fileName);

        $storage = new AWS_Storage();   #Uploading to cloud
        $imgID = $storage->uploadImage($this->filePath);
        $imgURI = $storage->getImage($imgID);

        unlink($this->filePath);    #Delete saved file
        return $imgURI;
    }
}