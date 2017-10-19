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
            'pattern' => '{width|int}x{height|int}[&{x|int},{y|int}]'
        ),
        'resize' => array(
            'title' => 'resize',
            'pattern' => '{width|int}x{height|int}'
        )
    );


    public function __construct($requestUri)
    {
        $cache = new \Cache\Cache();
        $cacheKey = $this->getCacheKey($requestUri);

        // Trying to get cached image
        $imageData = $cache->get($cacheKey);

        // If no cached image then create it
        if ( !$imageData ) {
            $imageData = $this->returnImage($requestUri);
            $cache->set($cacheKey, $imageData);
        }

        \HTTP\Response::data($imageData);
    }

    /**
     * Get cache key by uri
     *
     * @param string $uri - request uri
     * @return string - cache key
     */
    protected function getCacheKey($uri)
    {
        return md5($uri);
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

      $imageData = array(
          'type'    => $type,
          'blob'    => $blob,
          'length'  => $length
      );

      return $imageData;
    }
}
