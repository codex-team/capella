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
                    <form method="post" action="/upload" enctype="multipart/form-data">
                        <label for="ImageFile" class="capella__button">Select picture</label>
                        <input id="ImageFile" type="file" name="file" hidden="true"/>
                        <input type="submit" value="Upload" hidden="true"/>
                    </form>
                    <form method="post" action="/upload" autocomplete="off">
                        <input class="capella__input" type="text" name="link" placeholder="Paste the URL"/>
                        <input type="submit" value="Upload" hidden="true"/>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>