<form method="post" enctype="multipart/form-data">
    <input type="file" name="ImageFile"/>
    <input type="submit" name="FileSubm" value="Accept"/>
</form>

<?php
require_once ('Image.class.php');
if(is_uploaded_file($_FILES['ImageFile']['tmp_name'])) {
    $NewFile = new FileImage($_FILES['ImageFile']);
    try {
        $NewFile->upload();
    } catch (WrongFileType $e) {
        echo $e->getMessage();
    } catch (WrongFileSize $e) {
        echo $e->getMessage();
    }
}
?>

<form method="get" action="">
    <input type="text" name="ImageLink"/>
    <input type="submit" name="LinkSubm" value="Accept"/>
</form>

<?php
if(!empty($_GET['ImageLink']) and isset($_GET['LinkSubm'])) {
    $NewFile = new LinkImage($_GET['ImageLink']);
    try {
        $NewFile->upload();
    } catch (WrongFileType $e) {
        echo $e->getMessage();
    } catch (WrongFileSize $e) {
        echo $e->getMessage();
    }
}
elseif (empty($_GET['ImageLink']) and isset($_GET['LinkSubm'])) {
    echo "Please, enter a link.";
}
?>