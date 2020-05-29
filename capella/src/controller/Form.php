<?php

namespace Controller;

use API;
use DB\DbNames;
use DB\Mongo;
use Env;
use HTTP;
use Methods;
use RateLimiter;
use Uploader;

/**
 * Class for processing uploading form or AJAX upload
 */
class Form
{
    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /** Middleware to reduce image upload intensity */
            $this->checkRateLimits();

            /** Check project's token */
            $projectId = $this->tryToFindProjectIdByToken();

            /** Process form data */
            if (isset($_FILES['file'])) {
                $this->uploadFile($projectId);
            } elseif (isset($_POST['link'])) {
                $this->uploadLink($projectId);
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
     *
     * @param string $projectId - source project for image
     */
    protected function uploadFile($projectId)
    {
        /** This way we have $_FILES['files'] as a one file or array with files */

        if (empty($_FILES['file']['name'])) {
            HTTP\Response::BadRequest();

            API\Response::error([
                'message' => 'File is missing'
            ]);
        } else {
            $uploader = new \Uploader($projectId);

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
     *
     * @param string $projectId - source project for image
     */
    protected function uploadLink($projectId)
    {
        if (empty($_POST['link'])) {
            HTTP\Response::BadRequest();

            API\Response::error([
                'message' => 'Link is missing'
            ]);
        } else {
            $uploader = new \Uploader($projectId);

            try {
                $imageData = $uploader->uploadLink((string) $_POST['link']);

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
            'id' => basename($imageData['link'], '.' . Uploader::TARGET_EXT), // Get ID as name without extension
            'url' => $imageData['link'],
            'mime' => $imageData['mime'],
            'width' => $imageData['width'],
            'height' => $imageData['height'],
            'color' => $imageData['color'],
            'size' => $imageData['size']
        ]);
    }

    /**
     * Check if client has allowed to upload image
     */
    private function checkRateLimits() {
        if (RateLimiter::instance()->isEnabled()) {
            $ip = Methods::getRequestSourceIp();
            $key = 'RATELIMITER_CLIENT_' . $ip;

            $requestAllowed = RateLimiter::instance()->check($key);

            if (!$requestAllowed) {
                HTTP\Response::TooManyRequests();

                API\Response::error([
                    'message' => RateLimiter::instance()->errorMessage()
                ]);
            }
        }
    }

    /**
     * Try to find project by given token
     *
     * @return string project's _id from MongoDB
     */
    private function tryToFindProjectIdByToken() {
        $token = !empty($_POST['token']) ? (string) $_POST['token'] : '';

        if ($token) {
            $mongoResponse = Mongo::connect()->{DbNames::PROJECTS}->findOne([
                'token' => $token
            ]);

            if (!empty($mongoResponse['_id'])) {
                /** Return project's id */
                return $mongoResponse['_id'];
            }
        }

        /**
         * If project was not found by target token then show an error
         */
        HTTP\Response::Forbidden();

        API\Response::error([
            'message' => 'Project token is bad or missing'
        ]);
    }
}
