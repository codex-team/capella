<?php


/**
 * Parent class, witch describes acceptable extension,
 * file size and methods that check these parameters.
 */
class Uploader
{
    const MAX_FILE_SIZE = 15 * 1024*1024*8;  // 15MB

    /**
     * Acceptable MIME-types
     */
    const MIME_TYPES = array(
        'image/jpg',
        'image/png',
        'image/jpeg',
        'image/gif'
    );

    const TARGET_EXT = 'png';

    /**
     * Temp files directory
     */
    const UPLOAD_DIR = 'upload/';

    public function __construct()
    {
        if (!file_exists(self::UPLOAD_DIR)) {
            mkdir(self::UPLOAD_DIR);
        }
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
     * @param $filepath - path to the file or url
     *
     * @throws Exception
     *
     * @return string - path to saved file
     *
     */
    protected function saveFileToUploadDir($filepath)
    {
        // Generate filename
        $path = Uploader::UPLOAD_DIR . \Methods::generateId() . "." . self::TARGET_EXT;

        // Save file to uploads dir
        file_put_contents($path, file_get_contents($filepath));

        // Get MIME-type from file
        $mimeType = mime_content_type($path);
        $ext = explode('/', $mimeType)[1];

        if ( ! $this->isValidMimeType($mimeType) ) {
            throw new \Exception('Wrong file type');
        };

        // Convert image to png
        $image = new Imagick($path);
        $image->setImageFormat(self::TARGET_EXT);
        $image->writeImage($path);

        // Add extension from MIME-type
        // $newPath = $path.'.'.$ext;
        // rename($path, $newPath);
        // $path = $newPath;

        return $path;
    }

    /**
     * Upload file to cloud and return capella url
     *
     * @param $filepath - path to file
     * @param $label - name of file
     * @return string - img url
     */
    protected function uploadToCloud($filepath, $label)
    {
        /** TODO return to get image from cloud */
        // $storage = new \AWS\Storage();
        // $label = $storage->uploadImage($filepath, $label);

        // TODO insert file info to database

        $imgURI = \Methods::getImageUri($label);

        return $imgURI;
    }

    /**
     * Check and upload image
     *
     * @param {string} $file      path to image
     * @param {string} $size      image size
     * @param {string} $mime      image mime-type
     * @return {string}           uploaded image uri
     */
    protected function upload($file, $size, $mime)
    {
        if ( !$file || !$size || !$mime) {
            throw new \Exception('Source is damaged');
        };

        if ( ! $this->isValidSize($size) ) {
            throw new \Exception('Source is too big');
        };

        if ( ! $this->isValidMimeType($mime) ) {
            throw new \Exception('Wrong source mime-type');
        };

        // Copy temp file to upload dir
        $filepath = $this->saveFileToUploadDir($file);
        $label = explode('.', basename($filepath))[0];


        // Upload file and get its ID
        $imgURI = $this->uploadToCloud($filepath, $label);

        // Delete temp file
        // unlink($filepath);

        return $imgURI;
    }

    /**
     * Public function for file uploading via POST form-data
     *
     * @param {array} $data       image file from $_FILES
     * @return {string}           uploaded image uri
     */
    public function uploadFile($data)
    {
        if (!is_uploaded_file($data['tmp_name'])) {
            throw new \Exception('File is missing');
        }

        $mime = mime_content_type($data['tmp_name']);

        return $this->upload($data['tmp_name'], $data['size'], $mime);
    }

    /**
     * Public function for uploading image by url
     *
     * @param {string} $url       path to image
     * @return {string}           uploaded image uri
     */
    public function uploadLink($url)
    {
        // Get link info
        $headers = @get_headers($url, 1);

        $size = $headers['Content-Length'];
        $mime = $headers['Content-Type'];

        return $this->upload($url, $size, $mime);
    }
}
