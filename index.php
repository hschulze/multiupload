<html>
<head>
<title>Insert title here</title>
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
				if(response == "success"){
					$('<li></li>').appendTo('#galerie').html('<a href="crop.php./uploads/'+file+'"><img src="./uploads/'+file+'" width="140" alt="Vorschau" /></a>');
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
		
	<ul id="files" ></ul>
	
	
	<div id="galerie_div">
		Vorhandene Uploads (Zum Bearbeiten Anklicken):
		<ul id="galerie">
			<?php 
				$dir = "uploads";
				$dirHandle = opendir($dir);
				
				while ($datei = readdir($dirHandle)) {
					if(!is_dir($datei)) {
						$bildinfo = pathinfo($dir."/".$datei);
						?>
						<li>
							<a href="<?php echo $bildinfo['dirname']."/".$bildinfo['basename'];?>">
								<img src="<?php echo $bildinfo['dirname']."/".$bildinfo['basename'];?>" width="140" alt="Vorschau" />
							</a>
						</li>
					<?php 
					}
				}
				closedir($dirHandle);
			?>
		</ul>
	</div>
</body>
</html>