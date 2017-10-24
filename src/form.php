<?php

/**
 * Detect POST request
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  /**
   * Upload file
   */
    if ( isset($_FILES['ImageFile']) ) {

        if ( empty($_FILES['ImageFile']['name']) ) {

            echo "Please, select a file.";

        } else {

            $uploader = new \Uploader();

            try {
                $link = $uploader->uploadFile($_FILES['ImageFile']);
                echo '<a href="'.$link.'">'.$link.'</a>';
            } catch (Exception $e) {
                echo $e->getMessage();
            }

        }

    }

    /**
     * Upload by link
     */

    if ( !empty($_POST['ImageLink']) && isset($_POST['LinkSubm']) ) {

        $uploader = new \Uploader();
        try {
            $link = $uploader->uploadLink($_POST['ImageLink']);
            echo '<a href="'.$link.'">'.$link.'</a>';
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    } elseif (empty($_POST['ImageLink']) && isset($_POST['LinkSubm'])) {

        echo "Please, enter a link.";

    }

} else {

    \HTTP\Response::MethodNotAllowed();

}
