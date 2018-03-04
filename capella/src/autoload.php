<?php

spl_autoload_register(function ($classname) {
    $pathParts = explode('\\', $classname);
    $pathToFile = __DIR__ . '/';
    for ($i = 0; $i < count($pathParts); $i++) {
        $pathToFile .= ($i + 1 == count($pathParts)) ? $pathParts[$i] . '.php' : strtolower($pathParts[$i]) . '/';
    }
    if (file_exists($pathToFile)) {
        include $pathToFile;
    }
});
