<!DOCTYPE html>
<html>
<head>
    <title>Main</title>
    <link rel="stylesheet" type="text/css" href="../public/build/bundle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>
<body>
    <div class="capella-background">
        <div class="capella">
            <div class="capella__contents">
                <img src="../public/app/img/Logo.png">
                <div class="capella__title">capella</div>
                <p>Upload file directly using drag & drop or clipboard.<br>You will instantly get link to your file.</p>
                <form method="post" action="/upload" enctype="multipart/form-data">
                    <label for="ImageFile" class="capella__button">Select picture</label>
                    <input id="ImageFile" type="file" name="ImageFile" hidden="true"/>
                    <input type="submit" name="FileSubm" value="Upload" hidden="true"/>
                </form>
                <form method="post" action="/upload" autocomplete="off">
                    <input class="capella__input" type="text" name="ImageLink" placeholder="Paste the URL"/>
                    <input type="submit" name="LinkSubm" value="Upload" hidden="true"/>
                </form>
            </div>
        </div>
    </div>
</body>
</html>