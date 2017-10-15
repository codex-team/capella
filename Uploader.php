<?php
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
        require_once ('FileImage.class.php');
        $New_File = new FileImage();
        $New_File->Initialization();
        $New_File->Checking();
    }
}
?>

<form method="get" action="">
    <input type="text" name="ImageLink"/>
    <input type="submit" name="LinkSubm" value="Accept"/>
</form>

<?php
if(!empty($_GET['ImageLink']) and isset($_GET['LinkSubm'])) {
    require_once ('ImageLink.class.php');
    $New_File = new LinkImage();
    $New_File->Initialization();
    $New_File->Checking();
    if($New_File->Flag) {
        $New_File->Uploading();
    }
}
elseif (empty($_GET['ImageLink']) and isset($_GET['LinkSubm'])) {
    echo "Please, enter a link.";
}
?>