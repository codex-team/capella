<?php
// Sanity check, install should only be checked from index.php
defined('DOCROOT') or exit('Install tests must be loaded from within index.php!');

if (version_compare(PHP_VERSION, '5.3', '<')) {
    // Clear out the cache to prevent errors. This typically happens on Windows/FastCGI.
    clearstatcache();
} else {
    // Clearing the realpath() cache is only possible PHP 5.3+
    clearstatcache(TRUE);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Capella Installation</title>

    <style type="text/css">
    body { width: 42em; margin: 0 auto; font-family: sans-serif; background: #fff; font-size: 1em; }
    h1 { letter-spacing: -0.04em; }
    h1 + p { margin: 0 0 2em; color: #333; font-size: 90%; font-style: italic; }
    code { font-family: monaco, monospace; }
    table { border-collapse: collapse; width: 100%; }
        table th,
        table td { padding: 0.4em; text-align: left; vertical-align: top; }
        table th { width: 12em; font-weight: normal; }
        table tr:nth-child(odd) { background: #eee; }
        table td.pass { color: #191; }
        table td.fail { color: #911; }
    #results { padding: 0.8em; color: #fff; font-size: 1.5em; }
    #results.pass { background: #191; }
    #results.fail { background: #911; }
    </style>

</head>
<body>

    <h1>Environment Tests</h1>

    <p>
        The following tests have been run to determine if <a href="http://capella.pics/">Capella</a> will work in your environment.
        <? /*
        If any of the tests have failed, consult the documentation
        for more information on how to correct the problem.
        */ ?>
    </p>

    <?php $failed = FALSE ?>

    <table cellspacing="0">
        <tr>
            <th>PHP Version</th>
            <?php if (version_compare(PHP_VERSION, '5.3.3', '>=')): ?>
                <td class="pass"><?php echo PHP_VERSION ?></td>
            <?php else: $failed = TRUE ?>
                <td class="fail">Kohana requires PHP 5.3.3 or newer, this version is <?php echo PHP_VERSION ?>.</td>
            <?php endif ?>
        </tr>
        <tr>
            <th>Uploads Directory</th>
            <?php if (is_dir(DOCROOT.'upload') AND is_writable(DOCROOT.'upload')): ?>
                <td class="pass"><?php echo DOCROOT.'upload/' ?></td>
            <?php else: $failed = TRUE ?>
                <td class="fail">The <code><?php echo DOCROOT.'upload/' ?></code> directory is not writable.</td>
            <?php endif ?>
        </tr>
        <tr>
            <th>SPL Enabled</th>
            <?php if (function_exists('spl_autoload_register')): ?>
                <td class="pass">Pass</td>
            <?php else: $failed = TRUE ?>
                <td class="fail">PHP <a href="http://www.php.net/spl">SPL</a> is either not loaded or not compiled in.</td>
            <?php endif ?>
        </tr>
        <tr>
            <th>cURL Enabled</th>
            <?php if (extension_loaded('curl')): ?>
                <td class="pass">Pass</td>
            <?php else: ?>
                <td class="fail">Capella can use the <a href="http://php.net/curl">cURL</a> extension to upload images by link.</td>
            <?php endif ?>
        </tr>
        <tr>
            <th>URI Determination</th>
            <?php if (isset($_SERVER['REQUEST_URI']) OR isset($_SERVER['PHP_SELF']) OR isset($_SERVER['PATH_INFO'])): ?>
                <td class="pass">Pass</td>
            <?php else: $failed = TRUE ?>
                <td class="fail">Neither <code>$_SERVER['REQUEST_URI']</code>, <code>$_SERVER['PHP_SELF']</code>, or <code>$_SERVER['PATH_INFO']</code> is available.</td>
            <?php endif ?>
        </tr>
        <tr>
            <th>Image Processing</th>
            <?php if (class_exists("Imagick")): ?>
                <td class="pass">Pass</td>
            <?php else: ?>
                <td class="fail">Capella uses <a href="http://php.net/imagick">ImageMagick</a> class to process images.</td>
            <?php endif ?>
        </tr>
        <tr>
            <th>Short open tags</th>
            <?php if (ini_get('short_open_tag')): ?>
                <td class="pass">Pass</td>
            <?php else: ?>
                <td class="fail">Capella requires <a href="http://php.net/manual/en/ini.core.php#ini.short-open-tag">short_open_tag</a> param to be enabled in php.ini.</td>
            <?php endif ?>
        </tr>
    </table>

    <?php if ($failed === TRUE): ?>
        <p id="results" class="fail">✘ Capella may not work correctly with your environment.</p>
    <?php else: ?>
        <p id="results" class="pass">✔ Your environment passed all requirements.<br />
            Remove the <code>install.php</code> file now.</p>
    <?php endif ?>

    <h1>Optional Tests</h1>

    <p>
        Capella may work without the following extensions, but they are recommended.
    </p>

    <table cellspacing="0">
        <tr>
            <th>Memcache</th>
            <?php if (class_exists("Memcache")): ?>
                <td class="pass">Pass</td>
            <?php else: ?>
                <td class="fail">Capella uses <a href="http://php.net/memcache">Memcache</a> to reduce the load on the server.</td>
            <?php endif ?>
        </tr>
    </table>

</body>
</html>
