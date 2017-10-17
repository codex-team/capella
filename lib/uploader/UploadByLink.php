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
        $headers = get_headers($url);

        $this->fileName = basename($url);
        $this->fileSize = $headers['Content-Length'];
    }

    private function saveFile()
    {
        $name = $this::UPLOAD_DIR . uniqid();

        file_put_contents($name, file_get_contents($_GET['ImageLink']));

        $this->fileMimeType = mime_content_type($name);
        $ext = basename($this->fileMimeType);

        $newName = $name.'.'.$ext;
        rename($name, $newName);
        $name = $newName;

        $this->filePath = realpath($name);
    }

    public function upload()
    {
        $this->checkSize();

        // Save file
        $this->saveFile();

        $this->checkExtension();

        // Upload to cloud
        $storage = new \AWS\Storage();
        $imgID = $storage->uploadImage($this->filePath);
        $imgURI = $storage->getImage($imgID);

        // Delete saved file
        unlink($this->filePath);

        return $imgURI;
    }
}
