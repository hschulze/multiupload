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
?>