<?php

require_once "vendor/aws/aws-autoloader.php";

class Storage
{
    /**
     * AWS s3 cloud storage params
     */
    const AWS_KEY = ""; //Amazon s3 cloud authorisation key
    const AWS_SECRET_KEY = ""; //Amazon s3 cloud secret key
    const AWS_S3_BUCKET = ""; //Amazon s3 bucket name
    const AWS_S3_REGION = ""; //Amazon s3 bucket region
    const AWS_S3_STORAGE_CLASS = ""; //Amazon s3 storage class

    /**
     *Upload initiator
     *
     * @param string $tmpFileName
     * @return array
     */
    public function putObject($tmpFileName)
    {
        return $this->uploadS3($tmpFileName);
    }

    /**
     * Main AWS s3 uploader
     *
     * @param string $tmpFileName
     * @return array
     */
    protected function uploadS3($tmpFileName)
    {
        $imageId = $this->generateImageId(32) . date("dmyHis");

        $S3Client = new \Aws\S3\S3Client([
            "version" => "latest",
            "region" => self::AWS_S3_REGION,
            "credentials" => [
                "key" => self::AWS_KEY,
                "secret" => self::AWS_SECRET_KEY
            ]
        ]);

        $result = $S3Client->putObject([
            "Bucket" => self::AWS_S3_BUCKET,
            "Key" => $imageId,
            "SourceFile" => $tmpFileName,
            "ACL" => "public-read",
            "StorageClass" => self::AWS_S3_STORAGE_CLASS
        ]);

        return ["imageId" => $imageId, "imageUrl" => $result['ObjectURL']];
    }

    /**
     * Random image ID generator
     *
     * @param int $length
     * @return string
     */
    protected function generateImageId($length = 32)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}