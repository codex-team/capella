<?php
    
require_once 'lib/AWS/Storage.php';
require_once 'lib/ImageProcessing.php';
require_once 'config.php';

class Delivery
{
    private $imgURL;
    private $img;
    private $imgWithFilters;
    private $memcacheObj;
    private $imgID;
    private $filters;

    /**
    * @param {string} Image ID
    * @param {array} $filters
    * @example [[0] => ('title' => $title, 'params' => ('w' => $w, 'h' => $h[, 'x' => $x, 'y' => $y]))]
    */
    public function __construct($imgID1, $filters1) {
        $imgID = $imgID1;
        $filters = $filters1;
        $memcacheObj = new Memcache;
        $memcacheObj->connect(MEMCACHE_HOST, MEMCACHE_PORT) or die('Memcache not connect');
        
        $cacheImg = $memcacheObj->get(md5($imgID+implode($filters)));
        if(!empty($cacheImg)) {
            $imgWithFilters = $cacheImg;
        }
        else {
            $imgURL = (new AWS_Storage())->getImage($imgID);
            $imgURL = $this->acceptFilters($imgURL, $filters);
        }
    }

    /**
    * @param {string} $imgURL
    * @param {array} $filters
    * @example [[0] => ('title' => $title, 'params' => ('w' => $w, 'h' => $h[, 'x' => $x, 'y' => $y]))]
    */
    function acceptFilters($imgURL, $filters) {
        $img = new ImageProcessing();
        $img->readImage($imgURL);
        foreach ($filters as $filter) {
            if ($filter->title == 'crop') {
                $img->cropImage($filter->params->w, $filter->params->h, $filter->params->x, $filter->params->y);
            }
            elseif ($filter->title == 'resize') {
                $img->resizeImage($filter->params->w, $filter->params->h);
            }
        }
    }

    /**
    * Output image in browser
    */
    public function returnImage() {
        if(!empty($imgWithFilters)) {
            return $imgWithFilters;
        }
        $imgWithFilters = $img->getImageBlob();
        $memcacheObj->set(md5($imgID+implode($filters)), $imgWithFilters, MEMCACHE_COMPRESSED, 60*60);
        return $imgWithFilters;
    }
}
