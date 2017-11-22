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
	<link rel="stylesheet" href="#">
</head>
<body>
	<h1><a href = "Index.PHP">CV Creation Software</a></h1>
    <h2>Name CV</h2>
    <?php
    	require "Config.PHP";
		$error1 = '';

    	if(isset($_POST['submit']) && !empty($_POST['CVname']))
		{
			$cvname = htmlspecialchars($_POST['CVname']);
			$sql = "SELECT `CVName` FROM " . $_SESSION['login_user'] . "_previous_cv";
			$result = $conn->query($sql);

			if($result->num_rows > 0)
			{
				// error, duplicate name
				$error = 'Duplicate name, please enter a unique CV name';
			}else
			{
				$sql = "INSERT INTO " . $_SESSION['login_user'] . "_previous_cv (CVName) VALUES ('$cvname')";
				$result = $conn->query($sql);
				if($result)
				{
					// success

				}else
				{
					// error
					$error = 'Failed to create CV ' . $cvname;
				}
			}
		}else
		{
			$error = 'Please enter a CV name';
		}
    ?>
    <form class="NameForm" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
		Name:<br>
		<input type = "text" name = "CVname" required>
		<input type = "submit" value = "Continue">
		<h4 class = "error"><?php echo $error; ?></h4>
    </form>
</body>
</html>