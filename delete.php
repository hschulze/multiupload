<?php
	$id = $_GET['id'];
	
	$db = new mysqli("localhost", "galerieuser", "galerieuser", "galerie");
	
	$stmt_select = $db->stmt_init();
	$stmt_select->prepare("SELECT originalname, vorschauname, filetype FROM bilder WHERE id = ?");
	$stmt_select->bind_param('s', $id);
	$stmt_select->execute();
	$stmt_select->bind_result($originalname, $vorschauname, $filetype);
	$stmt_select->fetch();
	$stmt_select->close();
	
	$stmt_delete = $db->stmt_init();
	$stmt_delete->prepare("DELETE FROM bilder WHERE id = ?");
	$stmt_delete->bind_param('s', $id);
	$stmt_delete->execute();
	$stmt_delete->close();
	
	$db->close();
	
	unlink("./uploads/" . $id . "." . $filetype);
	if($vorschauname != "") {
		unlink("./uploads/" . $vorschauname . ".jpg");
	}
	
	// Weiterleitung auf die index.php
	//print_r($_SERVER);
	$path = pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME);
	//echo "<br /><br />$path";
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: http://" . $_SERVER['HTTP_HOST'] . $path . "/index.php");
?>