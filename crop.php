<html>
<head>
<title>Insert title here</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

</head>
<body>
	<div id="galerie_div">
		<?php 
			$verbindung = mysql_connect("localhost", "galerieuser", "galerieuser", "galerie") or die("Keine Verbindung zur DB möglich.");
			mysql_select_db("galerie") or die("Die DB existiert nicht");
			
			$id = $_GET['id'];
			
			$abfrage = "SELECT id, originalname, vorschauname, filetype, timestamp FROM bilder WHERE id = '".$id."'";
			$result = mysql_query($abfrage);
			
			$row = mysql_fetch_object($result);
			echo "$row->id, $row->originalname, $row->vorschauname, $row->filetype, $row->timestamp <br />";
			?>
			<img src="./uploads/<?php echo "$row->id.$row->filetype";?>" />
			<!-- <img src="<?php echo $bildinfo['dirname']."/".$bildinfo['basename'];?>" width="140" alt="Vorschau" />  -->
			
			<?php 
			mysql_close($verbindung);
		?>
		<br />
		<a href="index.php">Zur&uuml;ck</a>
	</div>
</body>
</html>