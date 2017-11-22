<?php

namespace Controller;

/**
 * Class for processing uploading form or AJAX upload
 */
class Form
{
    public function __construct() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ( isset($_FILES['file']) ) {

                $this->uploadFile();

            } elseif ( isset($_POST['link']) ) {

                $this->uploadLink();

            } else {

                \API\Response::BadRequest(array(
                    'success' => false,
                    'message' => 'File or link is missing'
                ));

            }

        } else {

            \API\Response::MethodNotAllowed(array(
                'success' => false,
                'message' => 'Method not allowed'
            ));

        }

    }

    /**
     * Function processed uploading file
     */
    protected function uploadFile() {

        # TODO add multiple file uploading support
        # This way we have $_FILES['files'] as a one file or array with files

        if ( empty($_FILES['file']['name']) ) {

            \API\Response::BadRequest(array(
                'success' => false,
                'message' => 'File is missing'
            ));

        } else {

            $uploader = new \Uploader();

            try {

                $link = $uploader->uploadFile($_FILES['file']);

                $this->returnImageLink($link);

            } catch (\Exception $e) {

                \API\Response::BadRequest(array(
                    'success' => false,
                    'message' => $e->getMessage()
                ));
            }

        }

    }

    /**
     * Function processed uploading by link
     */
    protected function uploadLink() {

        if ( empty($_POST['link']) ) {

            \API\Response::BadRequest(array(
                'success' => false,
                'message' => 'Link is missing'
            ));

        } else {

            $uploader = new \Uploader();

            try {

                $link = $uploader->uploadLink($_POST['link']);

                $this->returnImageLink($link);

            } catch (\Exception $e) {

                \API\Response::BadRequest(array(
                    'success' => false,
                    'message' => $e->getMessage()
                ));

            }

        }

    }

    /**
     * Return success result with image link
     *
     * @param string $link
     */
    protected function returnImageLink($link) {

        \API\Response::OK(array(
            'success' => true,
            'message' => 'Image uploaded',
            'id' => basename($link),
            'url' => $link
        ));

    }

}
