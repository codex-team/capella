<?php

namespace Uploader;

/**
 * Parent class, witch describes acceptable extension,
 * file size and methods that check these parameters.
 */
class Uploader
{
    const MAX_FILE_SIZE = 15 * 1024*1024*8;  // 15MB

    // Acceptable MIME-types
    const MIME_TYPES = array(
        'image/jpg',
        'image/png',
        'image/jpeg',
        'image/gif'
    );

    const UPLOAD_DIR = 'upload/';

    // protected $fileSize;
    // protected $fileMimeType;
    // protected $filePath;
    // protected $fileName;

    public function __construct($data)
    {
        
    }

    /**
     * Check extension
     */
    protected function checkExtension()
    {
        if ( !in_array($this->fileMimeType, self::MIME_TYPES) ) {
            throw new \Exception("Wrong file type");
        }
    }

    /**
     * Check file size
     */
    protected function checkSize()
    {
        if ($this->fileSize > self::MAX_FILE_SIZE) {
            throw new \Exception('The file is too big');
        }
    }

    /**
     * Save file to uploads dir
     *
     * @param $filepath     path to the file or url
     * @return $name        saved file name
     */
    protected function saveFileToUploadDir($filepath)
    {
        // Generate filename
        $name = Uploader::UPLOAD_DIR . uniqid();

        // Save file to uploads dir
        file_put_contents($name, file_get_contents($filepath));

        // Get MIME-type from file
        $mimeType = mime_content_type($name);
        $ext = basename($mimeType);

        // Add extension from MIME-type
        $newName = $name.'.'.$ext;
        rename($name, $newName);
        $name = $newName;

        return $name;
    }

    /**
     * Upload file to cloud and return url
     *
     * @param $filepath     path to file
     * @return $imgURI
     */
    protected function uploadToCloud($filepath)
    {
        $storage = new \AWS\Storage();
        $imgID = $storage->uploadImage($filepath);
        $imgURI = $storage->getImageURL($imgID);

        return $imgURI;
    }

    protected function uploadFile()
    {
        # code...
    }
}
