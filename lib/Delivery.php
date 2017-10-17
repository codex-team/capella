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
    private $imgKey;

    /**
    * @param {string} Image ID
    * @param {array} $filters
    * @example [[0] => ('title' => $title, 'params' => ('w' => $w, 'h' => $h[, 'x' => $x, 'y' => $y]))]
    */
    public function __construct($imgID1, $filters1) {
        $this->imgID = $imgID1;
        $this->filters = $filters1;
        $this->memcacheObj = new Memcache;
        $this->memcacheObj->connect(MEMCACHE_HOST, MEMCACHE_PORT) or die('Memcache not connect');
        $this->imgKey = $this->keyGenerate($this->imgID+implode($this->filters));
        
        $cacheImg = $this->memcacheObj->get($this->imgKey);
        if(!empty($cacheImg)) {
            $this->imgWithFilters = $cacheImg;
        }
        else {
            $this->imgURL = (new AWS_Storage())->getImage( $this->imgID);
            $this->imgURL = $this->acceptFilters($this->imgURL,  $this->filters);
        }
    }

    /**
     * @param {string} $string
     * @return {string} hash
     */
    function keyGenerate($string) {
        return hash('sha256', $string);
    }

    /**
    * @param {string} $imgURL
    * @param {array} $filters -- [[0] => ('title' => $title, 'params' => ('w' => $w, 'h' => $h[, 'x' => $x, 'y' => $y]))]
    */
    function acceptFilters($imgURL, $filters) {
        $this->img = new ImageProcessing($imgURL);
        foreach ($filters as $filter) {
            switch ($filter['filter1']) {
                case 'crop':
                    $this->img->cropImage($filter[params][w], $filter[params][h], $filter[params][x], $filter[params][y]);
                    break;
                case 'resize':
                    $this->img->resizeImage($filter[params][w], $filter[params][h]);
                    break;
            }
        }
    }

    /**
    * Output image in browser
    */
    public function returnImage() {
        if(!empty($this->imgWithFilters)) {
            return $this->imgWithFilters;
        }
        $this->imgWithFilters = $this->img->getImageBlob();
        $this->memcacheObj->set($this->imgKey, $this->imgWithFilters, MEMCACHE_COMPRESSED, 60*60);
        return $this->imgWithFilters;
    }
}
