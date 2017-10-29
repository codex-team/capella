<!DOCTYPE html>
<html>
<body>
<div id="dropContainer" style="border:1px solid black;height:100px;">
    drop zone
</div>
file
<form>
    <input type="file" name="file" id="fileInput"/>
    <input type="submit" value="Upload">
</form>


<div>link</div>
<form method="post" action="/upload">
    <input type="text" name="link">
    <input type="submit" value="Upload">
</form>
<script src="/cap2/src/js/dragndrop.js"></script>
</body>
</html>

