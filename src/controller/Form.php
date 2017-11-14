<?php

namespace Controller;

/**
 * Class for processing uploading form or AJAX upload
 */
class Form
{
    public function __construct() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ( isset($_FILES['files']) ) {

                $this->uploadFile();

            } elseif ( isset($_POST['link']) ) {

                $this->uploadLink();

            } else {

                \HTTP\Response::BadRequest();

            }

        } else {

            \HTTP\Response::MethodNotAllowed();

        }

    }

    /**
     * Function processed uploading file
     */
    protected function uploadFile() {

        # TODO add multiple file uploading support
        # This way we have $_FILES['files'] as a one file or array with files

        if ( empty($_FILES['files']['name']) ) {

            \HTTP\Response::BadRequest('File is missing');

        } else {

            $uploader = new \Uploader();

            try {

                $link = $uploader->uploadFile($_FILES['files']);

                $this->returnImageLink($link);

            } catch (\Exception $e) {

                \HTTP\Response::InternalServerError($e->getMessage());

            }

        }

    }

    /**
     * Function processed uploading by link
     */
    protected function uploadLink() {

        if ( empty($_POST['link']) ) {

            \HTTP\Response::BadRequest('Link is missing');

        } else {

            $uploader = new \Uploader();

            try {

                $link = $uploader->uploadLink($_POST['link']);

                $this->returnImageLink($link);

            } catch (\Exception $e) {

                \HTTP\Response::InternalServerError($e->getMessage());

            }

        }

    }

    /**
     * Show result on page with image link
     *
     * @param string $link
     */
    protected function returnImageLink($link) {

        if (\Methods::isAjax()) {

            \HTTP\Response::ajax(array(
                'url' => $link
            ));

        } else {

            $url = '/file/' . basename($link)
            \HTTP\Redirect::redirect($url, 303);

        }

    }

}
