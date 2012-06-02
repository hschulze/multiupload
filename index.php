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
					$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
				} else{
					$('<li></li>').appendTo('#files').text(file).addClass('error');
				}
			}
		});
		
	});
</script>

</head>
<body>
	<div id="upload" ><span>Upload File</span></div><span id="status"></span>
		
	<ul id="files" ></ul>
</body>
</html>