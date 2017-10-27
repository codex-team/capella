<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/cap2/src/js/form_script.js"></script>
<link rel="stylesheet" type="text/css" href="/cap2/src/css/form.css">
<div class="zoneupload">
    <legend>Отправить файл</legend>
    <form method="post" method="post" action="/upload" enctype="multipart/form-data" name="upload" id="upload">
        <input type="hidden" name="post" value="file"/>
        <input type="file" name="filez" id="filez" class="filez"/>
        <input type="submit" value="Send" id="send"/>
        <br>
        <p>Перекиньте файл в кораловое окно</p>
        <span id="activite"></span>
    </form>
</div>
<div class="zoneupload-next">
    <legend>Получить файл по ссылке</legend>
    <form method="post" action="/upload">
        <input type="text" name="link"/>
        <input type="submit" value="Upload"/>
    </form>
</div>