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
	<!-- <link rel="stylesheet" href="css/upload.css"> -->
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
                $filename = explode(".", $target_file)[0].date("dYHis").".docx";
				if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $filename))
				{
                    require "docxtotext.php";
                    require "Config.PHP";

                    $docObj = new Doc2Txt($filename);
                    $docText = $docObj->convertToText();

                    // Tracking Variables
                    $inside = false;
                    $inBox = false;
                    $setName = false;
                    $setValue = false;
                    $d = false;
                    $colName = "";
                    $value = "";
                    $colValue = "";
                    $template = [];

                    for($i=0;$i<strlen($docText);$i++)
                    {
                        echo $docText{$i};
                        switch($docText{$i})
                        {
                            case '@':
                                if(!$inside)
                                    $inside = $setName = true;
                                else if($setValue)
                                {
                                    $setValue = false;
                                    $colValue = $value;
                                    $value = "";

                                    $template[$colName] = $colValue;
                                }
                                break;
                            case '$':
                                // Set respective variable
                                if($setName)
                                {
                                    $setName = false;
                                    $colName = utf8_encode($value);
                                    $setValue = true;
                                    $value = "";
                                }else{
                                    $inside = $setName = $setValue = $d = false;
                                }
                                break;
                            default:
                                if($inside)
                                    $value .= $docText{$i};
                                break;
                        }
                    }

                    $keys = "";
                    $values = "";
                    for($template as $key => $value)
                    {
                        $keys .= $key . ",";
                        if(intval($value))
                            $values .= $value . ",";
                        else
                            $values .= '"' . $value . '",';
                    }
                    $keys{strlen($keys)-1} = '';
                    $values{strlen($values)-1} = '';

                    $sql = "INSERT INTO " . $_SESSION['login_user'] . "_templates (" . $keys . ") VALUES (" . $values . ");";
                    if($conn->query($sql))
                        $error = $filename . ' uploaded successfully. ';
                    else
                        $error = "Error sending template to database.";
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
