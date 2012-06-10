<?php
	
	$thumbid = $_POST['thumbid'];
	$description = $_POST['description'];
	
	$db = new mysqli("localhost", "galerieuser", "galerieuser", "galerie");
	$stmt = $db->stmt_init();
	if(!$stmt->prepare("UPDATE bilder SET description = ? WHERE id = ?")) {
		die($db->error);
	}
	$stmt->bind_param('si', $description, $thumbid);
	$stmt->execute();
	
	$affected_rows = $stmt->affected_rows;
	
	$stmt->close();
	$db->close();
	
	if($affected_rows == 1) {
		echo json_encode(array("success" => "true"));
	} else {
		echo json_encode(array("success" => "false"));
	}
?>