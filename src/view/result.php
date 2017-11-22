<!DOCTYPE html>
<html lang="en-us">
    <head>
        <title>Capella — file screen</title>
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
        <div class="capella result">
            <img class="result__img" src="/public/app/img/tim-cook.png">
            <div class="result__footer">
                <div class="result__footer-filters">
                    <img class="result__icon-copy" src="/public/app/svg/icon-copy.svg">
                    <a href="">https://capella.ifmo.su/f57fd76c-f24d-414e-91b1-554f37b7abb4</a>
                    <input type="text" value="+  /resize___x___" name="">
                    <input type="text" value="+  /crop___x___" name="">
                </div>
                <a class="result__copy-mobile" href="">
                    <img class="result__icon-copy" src="/public/app/svg/icon-copy.svg">Copy link
                </a>
                <div class="result__footer-about">
                    <img class="result__footer-logo" src="/public/app/svg/logo-horizontal.svg">
                    <a class="result__footer-link" href="">About</a>
                    <a class="result__footer-link" href="">API</a>
                    <a class="codex-team" href="">CodeX</a>
                </div>
            </div>
        </div>
        <script src="/public/build/bundle.js?v=<?= filemtime('public/build/bundle.js') ?>" onload="capella.init();"></script>
    </body>
</html>
