<?php
const MaxFileSize = 5000000000000;
#Сейчас поставил макcимальный размер файла,который можно загрузить на Amazon - 5TB. Жду от вас нормального размера.
const EXPANSIONS = array('image/jpg', 'image/png', 'image/jpeg', 'image/gif', 'jpg', 'png', 'jpeg', 'gif');
?>
<form method="post" enctype="multipart/form-data" action="">
    <input type="file" name="image"/>
    <input type="submit" name="FileSubm" value="Accept"/>
</form>
<?php
if(isset($_POST['FileSubm'])) {
    $FileName = $_FILES['image']['name'];
    $FileExp = $_FILES['image']['type'];
    $FileSize = $_FILES['image']['size'];
    if (!in_array($FileExp, EXPANSIONS)) {
        echo "Wrong file type.";
    }
    elseif ($FileSize > MaxFileSize) {
        echo "The file is too big.";
    }
    else {
        #Вызов функции putObject из storage.php
        echo "Success";
    }
}
?>
<form method="get" action="">
    <input type="text" name="FileLink" value="Put your link here"/>
    <input type="submit" value="Accept"/>
</form>
<?php
if($_GET['FileLink']) {
    $FileName = basename($_GET['FileLink']);
    $FileExp = explode('.', $_GET['FileLink']);
    $FileExp = $FileExp[count($FileExp)-1];
    if (!in_array($FileExp, EXPANSIONS)) {
        echo "Wrong file type.";
    }
    else {
        #Вызов функции putObject из storage.php
        echo "Success";
    }
}
?>