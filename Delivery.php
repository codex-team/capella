<?php
	require_once 'lib/AWS/Storage.php';
	require_once 'lib/ImageProcessing.php';

class Delivery
{

	private $imgURL;
	private $img;
	private $imgWithFilters;
	private $memcacheObj;

	/**
	* @param {string} Image ID
	* @param {array} $filters
	* example [[0] => ('title' => $title, 'params' => ('w' => $w, 'h' => $h[, 'x' => $x, 'y' => $y]))]
	*/
	public function __construct($imgID, $filters) {
		$memcacheObj = new Memcache;
		$memcacheObj->connect('127.0.0.1', 11211) or die('Memcache not connect');
		
		$cacheImg = $memcacheObj->get('our_var');
		if(!empty($cacheImg)) $imgWithFilters = $cacheImg;
		else {
			$imgURL = $this->getFileById($imgID);
			$imgURL = $this->acceptFilters($imgURL, $filters);
		}
	}

	/**
	* @param {string} Image ID
	*/
	function getFileById($imgID)
	{
		return (new AWS_Storage())->getImage($imgID);
	}

	/**
	* @param {string} $imgURL
	* @param {array} $filters
	* example [[0] => ('title' => $title, 'params' => ('w' => $w, 'h' => $h[, 'x' => $x, 'y' => $y]))]
	*/
	function acceptFilters($imgURL, $filters) {
		$img = new ImageProcessing();
		$img->readImage($imgURL);
		foreach ($filters as $filter) {
			if ($filter->title == 'crop') $img->cropImage($filter->params->w, $filter->params->h, $filter->params->x, $filter->params->y);
			elseif ($filter->title == 'resize') $img->resizeImage($filter->params->w, $filter->params->h);
		}
	}

	/**
	 * Output image in browser
	 */
	public function returnImage() {
		if(!empty($imgWithFilters)) return $imgWithFilters;
		$imgWithFilters = $img->getImageBlob();
        $memcacheObj->set('var_key', $imgWithFilters, MEMCACHE_COMPRESSED, 60*60);
		return $imgWithFilters;
	}
}
