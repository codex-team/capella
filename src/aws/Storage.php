<?php

namespace AWS;

/**
 * AWS Storage class
 *
 * @example Require Storage.php
 * require_once 'lib/AWS/Storage.php';
 *
 * @example Create new class
 * $storage = new \AWS\Storage();
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
class Storage
{
    protected $S3Client;

    protected $config;

    /**
     * Storage constructor
     */
    public function __construct()
    {
        $this->config = include "config.php";

        $this->S3Client = new \Aws\S3\S3Client([
            "version" => "latest",
            "region" => $this->config['AWS_S3_REGION'],
            "credentials" => [
                "key" => $this->config['AWS_KEY'],
                "secret" => $this->config['AWS_SECRET_KEY']
            ]
        ]);
    }

    /**
     * Get path to image function
     *
     * @param $imageId
     * @return bool|string - false if file not exist, URL if file exist
     */
    public function getImageURL($imageId)
    {
        $imageUrl = "https://" . $this->config['AWS_S3_BUCKET'] . ".s3.amazonaws.com/" . $imageId;

        if (@fopen($imageUrl, "r")) {
            return $imageUrl;
        } else {
            return false;
        }
    }

    /**
     * Upload initiator
     *
     * @param {string} $filepath      path to file to upload
     * @param {string} $label         name of file stored in cloud
     * @return {string}               uploaded image ID
     */
    public function uploadImage($filepath, $label)
    {
        return $this->uploadS3($filepath, $label);
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
            "Bucket" => $this->config['AWS_S3_BUCKET'],
            "Key" => $imageId,
            "SourceFile" => $tmpFileName,
            "ACL" => "public-read",
            "StorageClass" => $this->config['AWS_S3_STORAGE_CLASS']
        ]);

        return $imageId;
    }
}
