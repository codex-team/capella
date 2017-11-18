<!DOCTYPE html>
<html lang="en-us">
    <head>
        <title>Capella</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../public/build/bundle.css">
        <link rel="icon" type="image/png" href="/favicon.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png" />
        <link rel="apple-touch-icon-precomposed" sizes="180x180" href="/apple-touch-icon-180x180.png" />
        <meta name="description" property="og:description" content="Cloud service for image storage and delivery. Upload files and accept image-filters on the fly with simple API">
        <meta name="keywords" content="cloud service,upload files,image storage">
        <meta name="image" property="og:image" content="<?= \Methods::getDomainAndProtocol(); ?>/meta_img.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    </head>
    <body>
        <div class="capella">
            <div class="capella__drag-n-drop">
                <div class="capella__contents">
                    <div class="capella__logo">
                        <img src="../public/app/svg/capella-logo.svg">
                    </div>
                    <div class="capella__dark-contents">
                        <p>Upload file directly using drag-n-drop or clipboard. You will instantly get link to your file.</p>
                        <button id="uploadFileButton" class="capella__button">Select picture</button><br>
                        <input id="uploadLinkField" type="text" class="capella__input" placeholder="Paste URL"/>
                    </div>
                    <div class="capella__drag-n-drop-activator">
                        <img src="../public/app/svg/cloud-computing.svg">
                        Drop file to upload
                    </div>
                </div>
            </div>
        </div>
        <script src="/public/build/bundle.js?v=<?= filemtime('public/build/bundle.js') ?>" onload="capella.init();"></script>
    </body>
</html>
