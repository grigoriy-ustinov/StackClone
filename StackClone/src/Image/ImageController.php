<?php
namespace Anax\Image;

class ImageController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
	
	public function showAction($filename,$width,$height)
	{
		if (!isset($filename))
		{
			echo "no file to show";
			die();
		}
		$path = $this->request->getBaseUrl();
		//Default img and cache catalog
		//cache have to be writable 777
		if(!defined('IMG_PATH'))
		{
			define('IMG_PATH', ANAX_INSTALL_PATH . 'webroot/img' . DIRECTORY_SEPARATOR);
		}
		if(!defined('CACHE_PATH'))
		{
			define('CACHE_PATH', ANAX_INSTALL_PATH . '/webroot/cache/');
		}
		
		$image = new \Anax\Image\Image($filename,$width,$height);
		
		$image->validate();
		$image->getImageInfo();
		$image->createFilenameForCache();
		$image->openOriginalImage();
		$image->calculateNewImage();
		$image->resizeImage();
	    $image->applyFilters();
	    $image->SaveAs();
		$toShow = $image->checkImageAndUse();
		
		if($toShow != null)
		{
			$filler = explode("/",$toShow);
			$endFilename = end($filler);
			$output = $path .'/cache/'. $endFilename;
		}
		else 
		{
			die('Could not fix image');
		}
		
		$imgLink = "<img src='{$output}' alt=''/>";
		return $imgLink;
	}
	
	
	public function addAction()
	{
		$this->views->add('image/add');
	}
	
	
	public function saveAction()
	{
		
		if(!defined('IMG_PATH'))
		{
			define('IMG_PATH', ANAX_INSTALL_PATH . 'webroot/img' . DIRECTORY_SEPARATOR);
		}
		if(isset($_FILES['picture'])&& ($_FILES['picture']['name'] != null))
		{
			$allowed = array('jpeg','jpg','png');
			$filename = $_FILES['picture']['name'];
			$tempvar = explode('.' , $filename);
			$fileext = strtolower(end($tempvar));
			$filetemp = $_FILES['picture']['tmp_name'];
			if(in_array($fileext,$allowed) === true)
			{
				$file_path = IMG_PATH . substr(md5(time()) , 0 , 10). '.' . $fileext;
				move_uploaded_file($filetemp, $file_path);
			}
			$this->response->redirect($this->request->getBaseUrl());
		}
	}
	
}