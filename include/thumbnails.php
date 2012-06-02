<?php
	function createThumbnail($file, $size) {
		$dirname  = pathinfo($file, PATHINFO_DIRNAME);
		$filename = pathinfo($file, PATHINFO_FILENAME);
		$filetype = pathinfo($file, PATHINFO_EXTENSION);
		
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
		
		$sourcepic = imagecreatefromjpeg($picture['file']);
		$destpic = imagecreatetruecolor($newwidth, $newheight);
		
		imagecopyresampled($destpic, $sourcepic, 0, 0, 0, 0, $newwidth, $newheight, $picture['width'], $picture['height']);
		
		imagejpeg($destpic, $dirname . "/tn_" . $filename . "." . $filetype, 80);
	}
?>