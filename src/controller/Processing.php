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
 *
 * @example crop filter
 *    capella.ifmo.su/aaaa-bbbb-cccc-ddddeeee/crop/300x100
 *
 * @example crop filter with specified coordinates
 *    capella.ifmo.su/aaaa-bbbb-cccc-ddddeeee/crop/300x100&40,60
 *
 * @example usage of two composed filters
 *    capella.ifmo.su/aaaa-bbbb-cccc-ddddeeee/crop/300x100&40,60/resize/1000x1000
 */
class Processing
{
    const FILTERS = array(
        'crop' => array(
            'title' => 'crop',
            'pattern' => '{width|int}[x{height|int}[&{x|int},{y|int}]]'
        ),
        'resize' => array(
            'title' => 'resize',
            'pattern' => '{width|int}[x{height|int}]'
        ),
        'pixelize' => array(
            'title' => 'pixelize',
            'pattern' => '{pixels|int}'
        )
    );


    public function __construct($requestUri)
    {
        /**
         * Trying to get cached image
         */
        $imageData = \Cache\Cache::instance()->get($requestUri);

        /**
         * If no cached image then create it
         */
        if ( !$imageData ) {

            /**
             * Try to process url or throw error message and code 400
             */
            try {

                $imageData = $this->returnImage($requestUri);

            } catch (\Exception $e) {

                \HTTP\Response::BadRequest();

                \API\Response::returnError(array(
                    'message' => $e->getMessage()
                ));

                die();
            }

            /**
             * Cache imageData result
             */
            \Cache\Cache::instance()->set($requestUri, $imageData);
        }

        /**
         * Return imageData
         */
        \API\Response::showData($imageData);
    }

    /**
     * Return image data by requestUri
     *
     * @param string $requestUri
     * @return array - image data
     *        $imageData['type'] string - image mime-type
     *        $imageData['blob'] string - blob image
     *        $imageData['length'] int - image size
     */
    protected function returnImage($requestUri)
    {
        $dispatcher = new \Dispatcher($requestUri, self::FILTERS);
        $imageId = $dispatcher->id;
        $filters = $dispatcher->parsedFilters;

        /** TODO return to get image from cloud */
        // $storage = new \AWS\Storage();
        // $imageUrl = $storage->getImageURL($imageId);

        /** TODO Rashardkodit' */
        $imageUrl = 'upload/' . $imageId . '.' . \Uploader::TARGET_EXT;

        if (!file_exists($imageUrl)) {

            \HTTP\Response::NotFound();

            die();

        }

        $imageProcessing = new \ImageProcessing($imageUrl);

        foreach ($filters as $filter) {

            switch ($filter['filter']) {

                case 'crop':

                    $params = $filter['params'];

                    $width = $params['width'];
                    $height = isset($params['height']) ? $params['height'] : null;
                    $x = isset($params['x']) ? $params['x'] : null;
                    $y = isset($params['y']) ? $params['y'] : null;

                    $imageProcessing->cropImage($width, $height, $x, $y);

                    break;

                case 'resize':

                    $params = $filter['params'];

                    $width = $params['width'];
                    $height = isset($params['height']) ? $params['height'] : null;

                    $imageProcessing->resizeImage($width, $height);

                    break;

                case 'pixelize':

                    $params = $filter['params'];

                    $pixels = $params['pixels'];

                    $imageProcessing->pixelizeImage($pixels);

                    break;
            }

        }

        $type = 'image/' . strtolower($imageProcessing->extension);
        $blob = $imageProcessing->getImageBlob();
        $length = strlen($blob);

        $imageData = array(
            'type'    => $type,
            'blob'    => $blob,
            'length'  => $length
        );

        return $imageData;
    }
}
