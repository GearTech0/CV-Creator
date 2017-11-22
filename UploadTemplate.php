<!DOCTYPE html>
<html lang="en-US">
<?php
    session_set_cookie_params(0);
    session_start();
    if(!isset($_SESSION['logged_in']))
    {
    	header("Location: Login.PHP");
    }
?>
<html>
<head>
	<title>CV Creation Software</title>
	<link rel="stylesheet" href="css/upload.css">
</head>
<body>
	<h1><a href = "Index.PHP">CV Creation Software</a></h1>
	<?php
		/**
		* This code creates an uploads folder for the user (if needed) and uploads the selected template
		* [target_file] [void] [File selected by the user to be uploaded]
		* No return values
		**/
		$target_dir = "uploads/" . $_SESSION['login_user'];
		if(!file_exists($target_dir))
		{
			mkdir($target_dir, 0777, true);
		}
		$allowed = array('docx');
		$target_file = $target_dir . '/' . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$error = '';
		$fileType = pathinfo($target_file, PATHINFO_EXTENSION);
		if(isset($_POST["submit"]))
		{
			// check for correct file type
			if(!in_array($fileType, $allowed))
			{
				$error = 'Error, wrong file type';
				$uploadOk = 0;
				exit();
			}else
			{
				if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
				{
					$error = basename($_FILES["fileToUpload"]["name"]) . ' uploaded successfully.';
				}else
				{
					$error = 'Upload failed';
				}
			}
		}
	?>
	<form class="fileupload" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post" enctype = "multipart/form-data">
		Select template to upload:<br>
		<input type = "file" name = "fileToUpload" id = "fileToUpload"><br><br>
		<input type = "submit" value = "Upload File" name = "submit">
	</form>
	<h4 class = "error"><?php echo $error; ?></h4>
	<h2><a href="TemplatePreview.PHP">View Templates</a></h2>
</body>
</html>