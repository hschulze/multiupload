<?php 	
	$id = $_GET['id'];
	
	$db = new mysqli("localhost", "galerieuser", "galerieuser", "galerie");
	$stmt = $db->stmt_init();
	$stmt->prepare("SELECT name, beschreibung FROM products WHERE id = ?");
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->bind_result($productname, $description);
	$stmt->fetch();
	$stmt->close();
	
?>

<html>
<head>
<title>Produkt bearbeiten - <?php echo "$productname"?></title>
<script src="js/jquery-latest.js" type="text/javascript"></script>
<script src="js/fileuploader.js" type="text/javascript"></script>

<script>        
	function createUploader(){            
		var uploader = new qq.FileUploader({
			element: document.getElementById('file-uploader'),
			action: 'new_upload.php',
			debug: true,
			// additional data to send
			params: {
				productid: '<?php echo "$id"?>',
			}
		});           
	}
        
	// in your app create uploader as soon as the DOM is ready
	// don't wait for the window to load  
	window.onload = createUploader;     
</script>

<link rel="stylesheet" type="text/css" href="css/style.css" />

</head>
<body>
	<div id="top"><?php echo "$productname"?></div>
	<div id="file-uploader">
		<noscript>			
			<p>Please enable JavaScript to use file upload.</p>
		</noscript>         
	</div>
	<br />
	<div id="galerie_div">
		Beschreibung:
		<div id="description"><?php echo "$description"?></div><br />
		Vorhandene Bilder zum <?php echo "$productname"?> (Zum Bearbeiten der Vorschau Anklicken):
		<ul id="galerie">
			<?php 
				$stmt = $db->stmt_init();
				if(!$stmt->prepare("SELECT id, thumbname, description FROM bilder WHERE productid = ? ORDER BY ismainthumb DESC")) {
					die($db->error);
				}
				$stmt->bind_param('i', $id);
				$stmt->execute();
				$stmt->bind_result($thumbid, $thumbname, $thumbdescription);
				while ($stmt->fetch()) {
					?>
					<li>
						<a href="modifythumb.php?id=<?php echo "$thumbid"?>">
							<img src="uploads/<?php echo "$thumbname.jpg";?>" width="140" height="140" alt="Vorschau" />
						</a>
					</li>
					<?php 
				}
				$stmt->close();
				$db->close();
			?>
		</ul>
	</div>
</body>
</html>