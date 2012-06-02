<html>
<head>
<title>Insert title here</title>
<script src="js/jquery-latest.js" type="text/javascript"></script>
<script src="js/jquery.MultiFile.js" type="text/javascript"></script>
</head>
<body>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
  		Send these files:<br>
  		<input type="file" name="pic[]" class="multi" />
  		<input type="submit" name="upload" value="Send files">
	</form>
    <?php
		
	?>
	test
</body>
</html>