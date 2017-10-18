<?php

namespace Uploader;

/**
 * Class to work with a link
 *
 * @example
 * $NewFile = new UploadByLink($_GET['ImageLink']);
 * try {
 *     $NewFile->upload();
 * } catch (Exception $e) {
 *     echo $e->getMessage();
 * }
 */
class UploadByLink extends Uploader
{
    public function __construct($url)
    {
        $headers = get_headers($url, 1);

        $this->fileName = basename($url);
        $this->fileSize = $headers['Content-Length'];
    }

    public function upload($url)
    {
        $this->checkSize();

        // Save file
        $this->filePath = Uploader::saveFileToUploadDir($url);

        // $this->checkExtension();

        // Upload to cloud
        $imgURI = Uploader::uploadToCloud($this->filePath);

        // Delete saved file
        unlink($this->filePath);

        return $imgURI;
    }
}
