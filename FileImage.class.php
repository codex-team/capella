<?php
const MAX_FILE_SIZE = 15*1024*1024*8; #15 МБ
const EXTENSIONS = array('image/jpg', 'image/png', 'image/jpeg', 'image/gif', 'jpg', 'png', 'jpeg', 'gif');

class FileImage
{
    private $FileSize;
    private $FileExp;
    private $FilePath;

    public function Initialization()
    {
        if(isset($_FILES['ImageFile']['type'])) {
            $this->FileExp = $_FILES['ImageFile']['type'];
        }
        if(isset($_FILES['ImageFile']['size'])) {
            $this->FileSize = $_FILES['ImageFile']['size'];
        }
        if(isset($_FILES['ImageFile']['tmp_name'])) {
            $this->FilePath = $_FILES['ImageFile']['tmp_name'];
        }
    }

    public function Checking()
    {
        if(!in_array($this->FileExp, EXTENSIONS)) {
            echo "Wrong file type.";
        }
        elseif($this->FileSize > MAX_FILE_SIZE) {
            echo "The file is too big.";
        }
        else {
            require_once 'lib/AWS/Storage.php';
            $storage = new AWS_Storage();
            $imgID = $storage->uploadImage($this->FilePath);
            $imgURI = $storage->getImage($imgID);
            echo $imgURI;
        }
    }
}