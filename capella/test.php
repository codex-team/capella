<?php

/**
 * Autoload vendor
 */
require_once 'vendor/autoload.php';

$filepath = 'car.mp4';

$ffmpeg = FFMpeg\FFMpeg::create();
$video = $ffmpeg->open($filepath);

$video->save(new FFMpeg\Format\Video\X264(), 'new_' . $filepath);