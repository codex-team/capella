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

                \HTTP\Response::BadRequest();

            }

        } else {

            \HTTP\Response::MethodNotAllowed();

        }

    }

    protected function uploadFile() {

        if ( empty($_FILES['file']['name']) ) {

            \HTTP\Response::BadRequest('File is missing');

        } else {

            $uploader = new \Uploader();

            try {

                $link = $uploader->uploadFile($_FILES['file']);

                $this->returnImageLink($link);

            } catch (\Exception $e) {

                \HTTP\Response::InternalServerError($e->getMessage());

            }

        }

    }

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

    protected function returnImageLink($link) {

        if (\Methods::isAjax()) {

            \HTTP\Response::ajax(array(
                'url' => $link
            ));

        } else {

            echo '<a href="'.$link.'">'.$link.'</a>';

        }

    }

}
