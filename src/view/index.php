<!DOCTYPE html>
<html>
    <head>
        <title>Main</title>
        <link rel="icon" href="./favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../public/build/bundle.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    </head>
    <body>
        <div class="capella-background">
            <div class="capella">
                <div class="capella__contents">
                    <div class="capella__logo"></div>
                    <div class="capella__title">
                        <img src="../public/app/svg/Capella-branding.svg">
                    </div>
                    <p>Upload file directly using drag-n-drop or clipboard. You will instantly get link to your file.</p>
                    <button id="uploadFileButton" class="capella__button">Select picture</button><br>
                    <input id="uploadLinkField" type="text" class="capella__input" placeholder="Paste the URL"/>
                </div>
            </div>
        </div>
        <script src="/public/build/bundle.js?v=<?= filemtime('public/build/bundle.js') ?>" onload="capella.init();"></script>
    </body>
</html>
