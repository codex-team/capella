<form method="post" enctype="multipart/form-data">
    <input type="file" name="ImageFile"/>
    <input type="submit" name="FileSubm" value="Accept"/>
</form>

<?php

  if ( isset($_FILES['ImageFile']) ) {

      if ( empty($_FILES['ImageFile']['name']) ) {

          echo "Please, select a file.";

      } else {

          $uploader = new \Uploader();

          try {
              echo $uploader->uploadFile($_FILES['ImageFile']);
          } catch (Exception $e) {
              echo $e->getMessage();
          }

      }

  }

?>

<form method="get" action="">
    <input type="text" name="ImageLink"/>
    <input type="submit" name="LinkSubm" value="Accept"/>
</form>

<?php

    if ( !empty($_GET['ImageLink']) && isset($_GET['LinkSubm']) ) {

        $uploader = new \Uploader();
        try {
            echo $uploader->uploadLink($_GET['ImageLink']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    } elseif (empty($_GET['ImageLink']) && isset($_GET['LinkSubm'])) {

        echo "Please, enter a link.";

    }

?>
