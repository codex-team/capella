<?php
require_once('Image.class.php');
?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="ImageFile"/>
    <input type="submit" name="FileSubm" value="Accept"/>
</form>

<?php
if(isset($_FILES['ImageFile'])) {
    if (empty($_FILES['ImageFile']['name'])) {
        echo "Please, select a file.";
    } else {
        try {
            $NewFile = new FileUploader($_FILES['ImageFile']);
            $NewFile->upload();
        } catch (AccessDenied $e) {
            echo $e->getMessage();
        } catch (WrongFileType $e) {
            echo $e->getMessage();
        } catch (WrongFileSize $e) {
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
if (!empty($_GET['ImageLink']) and isset($_GET['LinkSubm'])) {
    $NewFile = new LinkUploader($_GET['ImageLink']);
    try {
        $NewFile->upload();
    } catch (WrongFileType $e) {
        echo $e->getMessage();
    } catch (WrongFileSize $e) {
        echo $e->getMessage();
    }
} elseif (empty($_GET['ImageLink']) and isset($_GET['LinkSubm'])) {
    echo "Please, enter a link.";
}
?>