<?php
const MAX_FILE_SIZE = 15*1024*1024*8; #15 МБ
const EXTENSIONS = array('image/jpg', 'image/png', 'image/jpeg', 'image/gif', 'jpg', 'png', 'jpeg', 'gif');

class LinkImage
{
    public $Flag = 0;
    private $FileSize;
    private $FileExp;
    private $FileName;
    private $FilePath;


    public function Initialization()
    {
        $this->FileName = basename($_GET['ImageLink']);
        $this->FileExp = explode('.', $_GET['ImageLink']);
        $this->FileExp = $this->FileExp[count($this->FileExp)-1];
        $this->FileSize = get_headers($_GET['ImageLink']);
        $this->FileSize = $this->FileSize['Content-Length'];
        echo $this->FileSize;
    }

    public function Checking()
    {
        if(!in_array($this->FileExp, EXTENSIONS)) {
            echo "Wrong file type.";
        }
        if($this->FileSize > MAX_FILE_SIZE) {
            echo "The file is too big.";
        }
        else {
            $this->Flag = 1;
        }
    }

    public function Uploading()
    {
        file_put_contents($this->FileName, file_get_contents($_GET['ImageLink']));
        $this->FilePath = realpath($this->FileName);
        require_once ('lib/AWS/Storage.php');
        $storage = new AWS_Storage();
        $imgID = $storage->uploadImage($this->FilePath);
        $imgURI = $storage->getImage($imgID);
        echo $imgURI;
    }
}