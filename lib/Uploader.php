<?php


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

    public function __construct()
    {
        mkdir(self::UPLOAD_DIR);
    }

    /**
     * Check extension
     */
    protected function isValidMimeType($mime)
    {
        if ( ! in_array($mime, self::MIME_TYPES) ) {
            return false;
        }

        return true;
    }

    /**
     * Check file size
     */
    protected function isValidSize($size)
    {
        if ( (int) $size > self::MAX_FILE_SIZE ) {
            return false;
        }

        return true;
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

        if ( ! $this->isValidMimeType($mimeType) ) {
            throw new \Exception("Wrong file type");
        };

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

    protected function upload($file, $size, $mime)
    {
        if ( !$file || !$size || !$mime) {
            throw new \Exception('File is damaged');
        };

        if ( ! $this->isValidSize($size) ) {
            throw new \Exception('The file is too big');
        };

        if ( ! $this->isValidMimeType($mime) ) {
            throw new \Exception("Wrong file type");
        };

        // Copy temp file to upload dir
        $filepath = Uploader::saveFileToUploadDir($file);

        // Upload file and get its ID
        $imgURI = Uploader::uploadToCloud($filepath);

        // Delete temp file
        unlink($filepath);

        return $imgURI;
    }

    public function uploadFile($data)
    {
        if (!is_uploaded_file($data['tmp_name'])) {
            throw new \Exception("File is missing");
        }

        $mime = mime_content_type($data['tmp_name']);

        return $this->upload($data['tmp_name'], $data['size'], $mime);
    }

    public function uploadLink($url)
    {
        // Get link info
        $headers = get_headers($url, 1);

        $size = $headers['Content-Length'];
        $mime = $headers['Content-Type'];

        return $this->upload($url, $size, $mime);
    }
}