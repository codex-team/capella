<!DOCTYPE html>
<html lang="en-us">
    <head>
        <title>Capella file screen</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/public/build/bundle.css?v=<?= filemtime('public/build/bundle.css') ?>">
        <link rel="icon" type="image/png" href="/favicon.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png" />
        <link rel="apple-touch-icon-precomposed" sizes="180x180" href="/apple-touch-icon-180x180.png" />
        <meta name="description" property="og:description" content="Cloud service for image storage and delivery. Upload files and accept image-filters on the fly with simple API">
        <meta name="keywords" content="cloud service,upload files,image storage">
        <meta name="image" property="og:image" content="<?= \Methods::getDomainAndProtocol(); ?>/meta_img.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    </head>
    <body>
        <div class="capella capella--result">
            <div class="capella__drag-n-drop">
                <div class="capella__contents">
                    <div class="capella__logo">
                        <img src="/public/app/svg/capella-logo.svg">
                    </div>
                    <div class="capella__result">
                        <img src="/public/app/img/result.png">
                        <div class="capella__result-info">File now available by this URL
                            <a name="js-copyable" class="capella__result-link" href="">https://capella.ifmo.su/f57fd76c-f24d-414e-91b1-554f37b7abb4</a>
                            Also, you can <a class="capella__cta-link">accept filters</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/public/build/bundle.js?v=<?= filemtime('public/build/bundle.js') ?>" onload="capella.init();"></script>
    </body>
</html>
