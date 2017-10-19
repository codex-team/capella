<?php

namespace Controller;

/**
 * Class Processing
 *
 * Get image by passed id, process it with passed filters and returns it on page
 *
 * @example get full size image
 *    capella.ifmo.su/aaaa-bbbb-cccc-ddddeeee
 *
 * @example resize filter
 *    capella.ifmo.su/aaaa-bbbb-cccc-ddddeeee/resize/100x100
 *    capella.ifmo.su/aaaa-bbbb-cccc-ddddeeee/r/100x100
 *
 * @example centered crop filter
 *    capella.ifmo.su/aaaa-bbbb-cccc-ddddeeee/crop/300x100
 *    capella.ifmo.su/aaaa-bbbb-cccc-ddddeeee/c/300x100
 *
 * @example crop filter with specified coordinates
 *    capella.ifmo.su/aaaa-bbbb-cccc-ddddeeee/crop/300x100&40,60
 *
 * @example usage of two composed filters
 *    capella.ifmo.su/aaaa-bbbb-cccc-ddddeeee/crop/300x100/resize/50x50
 *    capella.ifmo.su/aaaa-bbbb-cccc-ddddeeee/c/300x100&40,60/r/1000x1000
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

        $imageUrl = $storage->getImageURL($imageId);

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
