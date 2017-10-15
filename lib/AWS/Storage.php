<?php

/**
 * AWS Storage class
 *
 * @example Require Storage.php
 * require_once 'lib/AWS/Storage.php';
 *
 * @example Create new class
 * $storage = new AWS_Storage();
 *
 * @example Upload image and get it's ID
 * $imgID = $storage->uploadImage('nice-pic.png');
 *
 * @example Get image uri
 * $imgURI = $storage->getImage($imgID);
 *
 * @example Show image uri
 * echo $imgURI;
 */
class AWS_Storage
{
    protected $S3Client;

    /**
     * Storage constructor
     */
    public function __construct()
    {
        require_once "config.php";

        $this->S3Client = new \Aws\S3\S3Client([
            "version" => "latest",
            "region" => AWS_S3_REGION,
            "credentials" => [
                "key" => AWS_KEY,
                "secret" => AWS_SECRET_KEY
            ]
        ]);
    }

    /**
     * Get path to image function
     *
     * @param $imageId
     * @return bool|string - false if file not exist, URL if file exist
     */
    public function getImage($imageId)
    {
        $imageUrl = "https://" . AWS_S3_BUCKET . ".s3.amazonaws.com/" . $imageId;
        if (@fopen($imageUrl, "r")) {
            return $imageUrl;
        } else {
            return false;
        }
    }

    /**
     * Upload initiator
     *
     * @param string $tmpFileName
     * @return string - uploaded image ID
     */
    public function uploadImage($tmpFileName)
    {
        return $this->uploadS3($tmpFileName, $this->generateImageId());
    }

    /**
     * Main AWS s3 uploader
     *
     * @param $tmpFileName
     * @param $imageId
     * @return string - uploaded image ID
     */
    protected function uploadS3($tmpFileName, $imageId)
    {
        $result = $this->S3Client->putObject([
            "Bucket" => AWS_S3_BUCKET,
            "Key" => $imageId,
            "SourceFile" => $tmpFileName,
            "ACL" => "public-read",
            "StorageClass" => AWS_S3_STORAGE_CLASS
        ]);

        return $imageId;
    }

    /**
     * Image ID generator
     *
     * @return string - generated ID
     */
    protected function generateImageId()
    {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
}
