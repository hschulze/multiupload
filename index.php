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
					$('<li></li>').appendTo('#galerie').html('<a href="crop.php?id='+response+'"><img src="./pic/no_pic.jpg" width="140" alt="Vorschau" /></a>');
				} else{
					$('<li></li>').appendTo('#galerie').text(file);
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
		Vorhandene Uploads (Zum Bearbeiten Anklicken):
		<ul id="galerie">
			<?php 
				$verbindung = mysql_connect("localhost", "galerieuser", "galerieuser") or die("Keine Verbindung zur DB möglich.");
				mysql_select_db("galerie") or die("Die DB existiert nicht");
				
				$abfrage = "SELECT id, originalname, vorschauname, filetype, timestamp FROM bilder ORDER BY timestamp DESC LIMIT 5";
				$result = mysql_query($abfrage);
				
				while ($row = mysql_fetch_object($result)) {
					//echo "$row->id, $row->originalname, $row->vorschauname, $row->filetype, $row->timestamp <br />";
					?>
					<li>
						<a href="crop.php?id=<?php echo "$row->id"?>">
							<?php
								if($row->vorschauname != null) { 
							?>
									<img src="uploads/<?php echo "$row->vorschauname.$row->filetype";?>" width="140" height="140" alt="Vorschau" />
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
				mysql_close($verbindung);
			?>
		</ul>
	</div>
</body>
</html>