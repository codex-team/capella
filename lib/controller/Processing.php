<?php

namespace Controller;

/**
 * Class Processing
 *
 * Get image by passed id, process it with passed filters and returns it on page
 *
 */
class Processing
{
    const FILTERS = array(
        'crop' => array(
            'title' => 'crop',
            'pattern' => '{width|int}x{height|int}[&{x|int},{y|int}]'
        ),
        'resize' => array(
            'title' => 'resize',
            'pattern' => '{width|int}x{height|int}'
        ),
        'c' => array(
            'title' => 'crop',
            'pattern' => '{width|int}x{height|int}[&{x|int},{y|int}]'
        ),
        'r' => array(
            'title' => 'resize',
            'pattern' => '{width|int}x{height|int}'
        )
    );


    public function __construct($requestUri)
    {
        $storage = new \AWS\Storage();

        $dispatcher = new \Router\Dispatcher($requestUri, self::FILTERS);

        $imageId = $dispatcher->id;
        $filters = $dispatcher->parsedFilters;

        $imageUrl = $storage->getImage($imageId);

        if (!$imageUrl) {
            \HTTP\Response::NotFound();
        }

        $imageProcessing = new \ImageProcessing($imageUrl);

        foreach ($filters as $filter) {

            switch ($filter['filter']) {

                case 'crop':

                    $params = $filter['params'];

                    $width = $params['width'];
                    $height = $params['height'];
                    $x = isset($params['x']) ? $params['x'] : null;
                    $y = isset($params['y']) ? $params['y'] : null;

                    $imageProcessing->cropImage($width, $height, $x, $y);

                    break;

                case 'resize':

                    $params = $filter['params'];

                    $width = $params['width'];
                    $height = $params['height'];

                    $imageProcessing->resizeImage($width, $height);

                    break;
            }

        }

        $type = 'image/' . strtolower($imageProcessing->extension);
        $blob = $imageProcessing->getImageBlob();
        $length = strlen($blob);

        \HTTP\Response::data($blob, $type, $length);
    }
}
