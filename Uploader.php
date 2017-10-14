<?php
const MAXFILESIZE = 125829120; #15 МБ
const EXTENSIONS = array('image/jpg', 'image/png', 'image/jpeg', 'image/gif', 'jpg', 'png', 'jpeg', 'gif');
?>
    <form method="post" enctype="multipart/form-data" action="">
        <input type="file" name="ImageFile"/>
        <input type="submit" name="FileSubm" value="Accept"/>
    </form>
<?php
if(isset($_FILES['ImageFile'])) {
    if(empty($_FILES['ImageFile']['name'])) {
        echo "Please, select a file.";
    }
    else {
        if (isset($_FILES['ImageFile']['name'])) {
            $FileName = $_FILES['ImageFile']['name'];
        }
        if (isset($_FILES['ImageFile']['type'])) {
            $FileExp = $_FILES['ImageFile']['type'];
        }
        if (isset($_FILES['ImageFile']['size'])) {
            $FileSize = $_FILES['ImageFile']['size'];
        }
        if (isset($FileExp) and !in_array($FileExp, EXTENSIONS)) {
            echo "Wrong file type.";
        } elseif (isset($FileSize) and $FileSize > MAXFILESIZE) {
            echo "The file is too big.";
        } else {
            #Вызов функции putObject из storage.php
            echo "Success";
        }
    }
}
?>
    <form method="get" action="">
        <input type="text" name="ImageLink"/>
        <input type="submit" name="LinkSubm" value="Accept"/>
    </form>
<?php
if(!empty($_GET['ImageLink'])) {
    $FileName = basename($_GET['ImageLink']);
    $FileExp = explode('.', $_GET['ImageLink']);
    $FileExp = $FileExp[count($FileExp)-1];
    if (!in_array($FileExp, EXTENSIONS)) {
        echo "Wrong file type.";
    }
    else {
        #Вызов функции putObject из storage.php
        echo "Success";
    }
}
else {
    echo "Please, enter a link.";
}
?>