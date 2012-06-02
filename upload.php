<?php
	include 'include/thumbnails.php';

	$uploaddir = './uploads/';
	
	$file = basename($_FILES['uploadfile']['name']);
	$filename = pathinfo($file, PATHINFO_FILENAME);
	$filetype = pathinfo($file, PATHINFO_EXTENSION);
	$timestamp = date("Y-m-d H:i:s");
	
	// DB-Eintrag
	$db = new mysqli("localhost", "galerieuser", "galerieuser", "galerie");
	
	$stmt_insert = $db->stmt_init();
	$stmt_insert->prepare("INSERT INTO bilder (originalname, filetype, timestamp) VALUES (?, ?, ?)");
	$stmt_insert->bind_param('sss', $filename, $filetype, $timestamp);
	
	$stmt_insert->execute();
	$stmt_insert->close();
	
	$stmt_id = $db->stmt_init();
	$stmt_id->prepare("SELECT id FROM bilder WHERE originalname = ? AND timestamp = ?");
	$stmt_id->bind_param('ss', $filename, $timestamp);
	$insert_result = $stmt_id->execute();
	$stmt_id->bind_result($id);
	
	$stmt_id->fetch();
	$file_id = $id;
	
	$stmt_id->close();
		
	$save_filename = $uploaddir . $file_id . "." . $filetype;
	
	$save_result = move_uploaded_file($_FILES['uploadfile']['tmp_name'], $save_filename);
	
	if(true) {
		$thumbnailfile = "tn_" . $file_id;
		createThumbnail($uploaddir . "/" . $file_id . "." . $filetype, 140);
		$stmt_update = $db->stmt_init();
		$stmt_update->prepare("UPDATE bilder SET vorschauname = ? WHERE id = ?");
		$stmt_update->bind_param('ss', $thumbnailfile, $file_id);
		$stmt_update->execute();
		$stmt_update->close();
	}
	
	$db->close();
	
	if ($save_result == true && $insert_result == true) {
		echo "$file_id";
	} else {
		echo "-1";
	}
?>