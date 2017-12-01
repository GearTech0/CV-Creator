<!DOCTYPE html>
<html lang="en-US">
<?php
	session_set_cookie_params(0);
	session_start();
	if(!isset($_SESSION['login_user']))
	{
		header("Location: Login.PHP");
	}
?>
<html>
<head>
	<title>CV Creation Software - Name CV</title>
	<link rel="stylesheet" href="css/NameCVPage.css">
</head>
<body>
	<h1><a href = "Index.PHP">CV Creation Software</a></h1>
    <h2>Name CV</h2>
    <?php
		/*
		* This code allows the user to name the cv they are about to create
		* This name is uploaded to the database and creates a new entry for a new cv
		* No parameters
		* No return values
		*/
    	require "Config.PHP";
		$error = '';

    	if(isset($_POST['submit']) && $_POST['CVname'] !== '')
		{
			$cvname = htmlspecialchars($_POST['CVname']);
			$table = $_SESSION['login_user'] . "_previous_cv";
			$sql = "INSERT INTO `" . $table . "` (CVName) VALUES ('" . $cvname. "')";
			$result = $conn->query($sql);
			if($result)
			{
				// success
				$_SESSION['currentCV'] = $cvname;
				header("Location: CVInfoInput.php");
				$conn->close();
				exit();
			}else
			{
				// error
				$error = 'CV name ' . $cvname . ' already created';
			}
		}else
		{
			$error = 'Please enter a CV name';
		}
		$conn->close();
    ?>
    <form class="NameForm" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
		Name:<br>
		<input type = "text" name = "CVname" required>
		<input type = "submit" value = "Continue" name="submit">
		<h4 class = "error"><?php echo $error; ?></h4>
    </form>
</body>
</html>
