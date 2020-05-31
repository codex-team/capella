<!DOCTYPE html>
<html lang="en-us">
<head>
    <title>Capella</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/public/build/bundle.css?v=<?= filemtime('public/build/bundle.css') ?>">
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png" />
    <link rel="apple-touch-icon-precomposed" sizes="180x180" href="/apple-touch-icon-180x180.png" />
    <meta name="description" property="og:description" content="Cloud service for image storage and delivery. Upload files and accept image-filters on the fly with simple API">
    <meta name="keywords" content="cloud service,upload files,image storage">
    <meta name="image" property="og:image" content="<?= App\Methods::getDomainAndProtocol(); ?>/meta_img.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <? $hawkToken = App\Env::get('HAWK_TOKEN') ?>
    <? if ($hawkToken): ?>
        <script src="/public/build/hawk.bundle.js?v=<?= filemtime('public/build/hawk.bundle.js') ?>" onload="hawk.init('<?= $hawkToken ?>');" async></script>
    <? endif ?>
</head>
<body>
    <div class="capella">
        <div id="projectForm" class="form">
            <h2>Apply form to start using Capella</h2>
            <input id="name" type="text" placeholder="Project's name" required></br>
            <input id="description" type="text" placeholder="Usage description" required></br>
            <input id="email" type="email" placeholder="Contact email" required></br>
            <button id="submitFormButton" class="form__button">Get an access token</button>
        </div>
    </div>

    <script src="/public/build/capella.bundle.js?v=<?= filemtime('public/build/capella.bundle.js') ?>" onload="capella.init();"></script>
</body>
</html>
