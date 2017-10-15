<?php
	require_once 'lib/AWS/Storage.php';
	require_once 'lib/ImageProcessing.php';

class Delivery
{

	private $imgURL;
	private $img;

	/**
		* @param {string} Image ID
		* @param {array} $filters
		* example [[0] => ('title' => $title, 'params' => ('w' => $w, 'h' => $h[, 'x' => $x, 'y' => $y]))]
		*/
	public function __construct($imgID, $filters) {
		$imgURL = $this->getFileById($imgID);
		$imgURL = $this->acceptFilters($imgURL, $filters);
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
	function returnImage() {
		$img->getImageBlob();
	}
}
