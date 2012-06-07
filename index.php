<?php 
	//no  cache headers 
	header("Expires: Mon, 26 Jul 1990 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
?>

<html>
<head>
<title>Multidateiupload</title>
<script src="js/jquery-latest.js" type="text/javascript"></script>
<script src="js/ajaxupload.3.5.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<script type="text/javascript" >
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#status');
		new AjaxUpload(btnUpload, {
			action: 'upload.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');
				//Add uploaded file to list
				//alert(response);
				if(response >= 0){
					$('<li></li>').prependTo('#galerie').html('<a href="modifythumb.php?id='+response+'"><img src="./uploads/tn_'+response+'.jpg" width="140" height="140" alt="Vorschau" /></a>');
					//$('<li></li>').appendTo('#galerie').html('<a href="crop.php?id='+response+'"><img src="./pic/no_pic.jpg" width="140" alt="Vorschau" /></a>');
				} else{
					$('<li></li>').prependTo('#galerie').text(file);
				}
			}
		});
	});
</script>

</head>
<body>
	<div id="top">Dateien hochladen</div>
	<div id="upload" ><span>Upload File</span></div><span id="status"></span>
	<br />
	<div id="galerie_div">
		Vorhandene Uploads (Zum Bearbeiten der Vorschau Anklicken):
		<ul id="galerie">
			<?php 
				$db = @new mysqli('localhost', 'galerieuser', 'galerieuser', 'galerie');
				if(mysqli_connect_errno() == 0) {
					$stmt = $db->stmt_init();
					if(!$stmt->prepare("SELECT id, originalname, vorschauname, filetype, timestamp FROM bilder ORDER BY timestamp DESC LIMIT 50")) {
						die($db->error);
					}
					$stmt->execute();
					$stmt->bind_result($id, $originalname, $vorschauname, $filetype, $timestamp);
					
					while ($stmt->fetch()) {
						//echo "$row->id, $row->originalname, $row->vorschauname, $row->filetype, $row->timestamp <br />";
						?>
						<li>
							<a href="modifythumb.php?id=<?php echo "$id"?>">
								<?php
									if($vorschauname != null) { 
								?>
										<img src="uploads/<?php echo "$vorschauname.jpg";?>" width="140" height="140" alt="Vorschau" />
								<?php 
									} else {
								?>
										<img src="pic/no_pic.jpg" width="140" height="140" alt="Keine Vorschau" />
								<?php 
									}
								?>
								<!-- <img src="<?php echo $bildinfo['dirname']."/".$bildinfo['basename'];?>" width="140" alt="Vorschau" />  -->
							</a>
						</li>
						<?php 
					}
					$stmt->close();
					$db->close();
				} else {
					echo "Es konnte keine Verbindung zur Datenbank hergestellt werden";
				}
			?>
		</ul>
	</div>
</body>
</html>