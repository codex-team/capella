<form method="post" action="" enctype="multipart/form-data">
    <input type="file" name="ImageFile"/>
    <input type="submit" name="FileSubm" value="Upload"/>
</form>

<?php

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

?>

<form method="post" action="">
    <input type="text" name="ImageLink"/>
    <input type="submit" name="LinkSubm" value="Upload"/>
</form>

<?php

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

?>
