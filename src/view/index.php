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
                    <div class="capella__logo"></div>
                    <div class="capella__title">
                        <img src="../public/app/img/Capella-branding.svg">
                    </div>
                    <p>Upload file directly using drag-n-drop or clipboard. You will instantly get link to your file.</p>
                    <button id="uploadFileButton" class="capella__button">Select picture</button>
                    <input id="uploadLinkField" type="text" class="capella__input" placeholder="Paste the URL"/>
                </div>
            </div>
        </div>
        <script src="/public/build/bundle.js?v=<?= filemtime('public/build/bundle.js') ?>" onload="capella.init();"></script>
    </body>
</html>
