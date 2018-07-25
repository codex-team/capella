<?php

namespace Controller;

use API;
use HTTP;
use Uploader;

/**
 * Class for processing uploading form or AJAX upload
 */
class Form
{
    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['file'])) {
                $this->uploadFile();
            } elseif (isset($_POST['link'])) {
                $this->uploadLink();
            } else {
                HTTP\Response::BadRequest();

                API\Response::error([
                    'message' => 'File or link is missing'
                ]);
            }
        } else {
            HTTP\Response::MethodNotAllowed();

            API\Response::error([
                'message' => 'Method not allowed'
            ]);
        }
    }

    /**
     * Function processed uploading file
     */
    protected function uploadFile()
    {
        /** This way we have $_FILES['files'] as a one file or array with files */

        if (empty($_FILES['file']['name'])) {
            HTTP\Response::BadRequest();

            API\Response::error([
                'message' => 'File is missing'
            ]);
        } else {
            $uploader = new \Uploader();

            try {
                $imageData = $uploader->uploadFile($_FILES['file']);

                $this->returnImageData($imageData);
            } catch (\Exception $e) {
                HTTP\Response::BadRequest();

                API\Response::error([
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Function processed uploading by link
     */
    protected function uploadLink()
    {
        if (empty($_POST['link'])) {
            HTTP\Response::BadRequest();

            API\Response::error([
                'message' => 'Link is missing'
            ]);
        } else {
            $uploader = new \Uploader();

            try {
                $imageData = $uploader->uploadLink($_POST['link']);

                $this->returnImageData($imageData);
            } catch (\Exception $e) {
                HTTP\Response::BadRequest();

                API\Response::error([
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Return success result with image link
     *
     * @param array $imageData
     */
    protected function returnImageData($imageData)
    {
        HTTP\Response::OK();

        API\Response::success([
            'message' => 'Image uploaded',
            /**
             * Get ID as name without extension
             */
            'id' => basename($imageData['link'], '.' . Uploader::TARGET_EXT),
            'url' => $imageData['link'],
            'mime' => $imageData['mime'],
            'width' => $imageData['width'],
            'height' => $imageData['height'],
            'color' => $imageData['color'],
            'size' => $imageData['size']
        ]);
    }
}
