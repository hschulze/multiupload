<?php 
	include 'include/thumbnails.php';
	
	$id = $_GET['id'];
	
	$db = new mysqli("localhost", "galerieuser", "galerieuser", "galerie");
	$stmt = $db->stmt_init();
	$stmt->prepare("SELECT originalname, vorschauname, filetype, timestamp FROM bilder WHERE id = ?");
	$stmt->bind_param('s', $id);
	$stmt->execute();
	$stmt->bind_result($originalname, $vorschauname, $filetype, $timestamp);
	$stmt->fetch();
	$stmt->close();
	$db->close();
	
	$thumb_width = "140";
	$thumb_height = "140";
	
	$thumb_image_location = "./uploads/tn_" . $id . ".jpg";
	$large_image_location = "./uploads/" . $id . "." . $filetype;
	
	$max_width = "500";
	
	$current_image_size = getimagesize("./uploads/" . $id . "." . $filetype);
	$current_large_image_width = $current_image_size[0];
	$current_large_image_height = $current_image_size[1];
	
	if (isset($_POST["upload_thumbnail"])) {
		//Get the new coordinates to crop the image.
		$x1 = $_POST["x1"];
		$y1 = $_POST["y1"];
		$x2 = $_POST["x2"];
		$y2 = $_POST["y2"];
		$w = $_POST["w"];
		$h = $_POST["h"];
		//Scale the image to the thumb_width set above
		$scale = $thumb_width/$w;
		$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
		//Reload the page again to view the thumbnail
		$path = pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME);
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: http://" . $_SERVER['HTTP_HOST'] . $path . "/index.php?");
		exit();
	}
	
//	if($current_large_image_width > $max_width) {
//		$scale = $max_width/$current_large_image_width;
//		$
//	}
?>

<html>
<head>
<title>Insert title here</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<script type="text/javascript" src="js/jquery-latest.js"></script>
<script type="text/javascript" src="js/jquery.imgareaselect.min.js"></script>
<script type="text/javascript">
	function preview(img, selection) { 
		var scaleX = <?php echo $thumb_width;?> / selection.width; 
		var scaleY = <?php echo $thumb_height;?> / selection.height; 
		
		$('#thumbnail + div > img').css({ 
			width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px', 
			height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
			marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
			marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
		});
		$('#x1').val(selection.x1);
		$('#y1').val(selection.y1);
		$('#x2').val(selection.x2);
		$('#y2').val(selection.y2);
		$('#w').val(selection.width);
		$('#h').val(selection.height);
	} 
	
	$(document).ready(function () { 
		$('#save_thumb').click(function() {
			var x1 = $('#x1').val();
			var y1 = $('#y1').val();
			var x2 = $('#x2').val();
			var y2 = $('#y2').val();
			var w = $('#w').val();
			var h = $('#h').val();
			if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
				alert("Bitte zunaechst eine Auswahl treffen!");
				return false;
			}else{
				return true;
			}
		});
	}); 
	
	$(window).load(function () { 
		$('#thumbnail').imgAreaSelect({ aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview }); 
	});

</script>


</head>
<body>
	<div id="galerie_div">
		<?php echo "$id, $originalname, $vorschauname, $filetype, $timestamp"; ?>
		<br />
		<img src="./uploads/<?php echo "$id.$filetype";?>" style="fload: left; margin-right: 10px;" id="thumbnail" />
		<div style="border: 1px #e1e1e1 solid; float: left; position: relative; overflow: hidden; width: <?php echo $thumb_width?>px; height: <?php echo $thumb_height?>px;">
			<img src="./uploads/tn_<?php echo "$id.$filetype";?>" style="position: relative;" />
		</div>
		<br />
		<form name="thumbnail" action="<?php echo $_SERVER["PHP_SELF"] . "?id=" . $id;?>" method="post">
				<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
				<input type="submit" name="upload_thumbnail" value="Vorschau sichern" id="save_thumb" />
		</form>
		<a href="index.php">Zur&uuml;ck</a> <a href="delete.php?id=<?php echo "$id"; ?>">L&ouml;schen</a>  
	</div>
</body>
</html>