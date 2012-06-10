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
	function saveThumbnailDescription(thumbnailId) {
		$.ajax({
			type: "POST",
			url: "s_savethumbdesc.php",
			dataType: "json",
			data: {
				thumbid: thumbnailId,
				description: $("#thumbnailDescription_" + thumbnailId).val()
			},
			success: function(data) { alert(data); $("#saveThumbnail_" + thumbnailId).attr("disabled", "disabled"); },
			error: function() { alert("error"); }
		});

	}

	function createUploader(){            
		var uploader = new qq.FileUploader({
			element: document.getElementById('file-uploader'),
			action: 's_upload.php',
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
						<textarea rows="4" cols="60" id="thumbnailDescription_<?php echo "$thumbid"?>"><?php echo "$thumbdescription";?></textarea>
						<input id="saveThumbnail_<?php echo "$thumbid"?>" type="button" value="Speichern" onClick="saveThumbnailDescription(<?php echo "$thumbid"?>)" disabled="disabled" />
						<!-- <input id="saveThumbnail_<?php echo "$thumbid"?>" type="button" value="Speichern" /> -->
						<script type="text/javascript">
							$("#thumbnailDescription_<?php echo "$thumbid"?>").change(function() {
									var hasDisabled = $("#saveThumbnail_<?php echo "$thumbid"?>").attr("disabled");
									if(typeof hasDisabled !== "undefined" && hasDisabled !== false) {
										$("#saveThumbnail_<?php echo "$thumbid"?>").removeAttr("disabled");
									}
								});
						</script>				
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