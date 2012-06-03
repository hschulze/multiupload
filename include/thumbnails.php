<?php
	function createThumbnail($file, $size) {
		$dirname  = pathinfo($file, PATHINFO_DIRNAME);
		$filename = strtolower(pathinfo($file, PATHINFO_FILENAME));
		$filetype = strtolower(pathinfo($file, PATHINFO_EXTENSION));
		
		$picture['file'] = $file;
		$imagesize = getimagesize($picture['file']);
		$picture['width'] = $imagesize[0];
		$picture['height'] = $imagesize[1];
		
		if ($picture['width'] > $picture['height']) {
			$newheight = $size;
			$newwidth = round($picture['height']/$picture['width']*$size);
		} else {
			$newheight = $size;
			$newwidth = round($picture['width']/$picture['height']*$size);
		}
		
		switch ($filetype) {
			case "jpg":
			case "jpeg":
				$sourcepic = imagecreatefromjpeg($picture['file']);
				break;
			case "gif":
				$sourcepic = imagecreatefromgif($picture['file']);
			case "png":
				$sourcepic = imagecreatefrompng($picture['file']);
				break;
		}
		
		$destpic = imagecreatetruecolor($newwidth, $newheight);
		
		imagecopyresampled($destpic, $sourcepic, 0, 0, 0, 0, $newwidth, $newheight, $picture['width'], $picture['height']);
		
		imagejpeg($destpic, $dirname . "/tn_" . $filename . ".jpg", 80);
	}
	
	function resizeImage($image,$width,$height,$scale) {
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$imageType = image_type_to_mime_type($imageType);
		$newImageWidth = ceil($width * $scale);
		$newImageHeight = ceil($height * $scale);
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		switch($imageType) {
			case "image/gif":
				$source=imagecreatefromgif($image); 
				break;
		    case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				$source=imagecreatefromjpeg($image); 
				break;
		    case "image/png":
			case "image/x-png":
				$source=imagecreatefrompng($image); 
				break;
	  	}
		imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
		
		switch($imageType) {
			case "image/gif":
		  		imagegif($newImage,$image); 
				break;
	      	case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
		  		imagejpeg($newImage,$image,90); 
				break;
			case "image/png":
			case "image/x-png":
				imagepng($newImage,$image);  
				break;
	    }
		
		chmod($image, 0777);
		return $image;
	}
	
	function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$imageType = image_type_to_mime_type($imageType);
		
		$newImageWidth = ceil($width * $scale);
		$newImageHeight = ceil($height * $scale);
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		switch($imageType) {
			case "image/gif":
				$source=imagecreatefromgif($image); 
				break;
		    case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				$source=imagecreatefromjpeg($image); 
				break;
		    case "image/png":
			case "image/x-png":
				$source=imagecreatefrompng($image); 
				break;
	  	}
		imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
		switch($imageType) {
			case "image/gif":
		  		imagegif($newImage,$thumb_image_name); 
				break;
	      	case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
		  		imagejpeg($newImage,$thumb_image_name,90); 
				break;
			case "image/png":
			case "image/x-png":
				imagepng($newImage,$thumb_image_name);  
				break;
	    }
		chmod($thumb_image_name, 0777);
		return $thumb_image_name;
	}
?>