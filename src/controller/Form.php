<?php

namespace Controller;

class Form
{
    public function __construct() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ( isset($_FILES['file']) ) {

                $this->uploadFile();

            } elseif ( isset($_POST['link']) ) {

                $this->uploadLink();

            } else {

                // File or link is missing
                $this->BadRequest();

            }

        } else {

            return $this->MethodNotAllowed();

        }

    }

    protected function uploadFile() {

        if ( empty($_FILES['file']['name']) ) {

            // File is missing
            $this->BadRequest();

        } else {

            $uploader = new \Uploader();

            try {

                $link = $uploader->uploadFile($_FILES['file']);

                $this->returnImageLink($link);

            } catch (Exception $e) {

                // echo $e->getMessage();
                $this->InternalServerError();

            }

        }

    }

    protected function uploadLink() {

        if ( empty($_POST['link']) ) {

            // Link is missing
            $this->BadRequest();

        } else {

            $uploader = new \Uploader();

            try {

                $link = $uploader->uploadLink($_POST['link']);

                $this->returnImageLink($link);

            } catch (Exception $e) {

                // echo $e->getMessage();
                $this->InternalServerError();

            }

        }

    }

    protected function returnImageLink($link) {

        if (\Methods::isAjax()) {

            \Methods::ajaxResponse(array(
                'code' => '200',
                'url' => $link,
            ));

        } else {

            echo '<a href="'.$link.'">'.$link.'</a>';

        }

    }

    protected function MethodNotAllowed() {

        if (\Methods::isAjax()) {

            \Methods::ajaxResponse(array(
                'code' => '405',
                'error' => 'Method Not Allowed'
            ));

        } else {

            \HTTP\Response::MethodNotAllowed();

        }

    }

    protected function BadRequest() {

        if (\Methods::isAjax()) {

            \Methods::ajaxResponse(array(
                'code' => '400',
                'error' => 'Bad Request'
            ));

        } else {

            \HTTP\Response::BadRequest();

        }

    }

    protected function InternalServerError() {

        if (\Methods::isAjax()) {

            \Methods::ajaxResponse(array(
                'code' => '500',
                'error' => 'Internal Server Error'
            ));

        } else {

            \HTTP\Response::InternalServerError();

        }

    }

}
