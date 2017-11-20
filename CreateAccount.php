<!DOCTYPE html>
<html lang="en-US">
<?php 
	session_set_cookie_params(0);
	session_start(); 
?>
<html>
<head>
	<title>CV Creation Software</title>
	<link rel="stylesheet" href="css/login.css">
</head>
<body>
	<h1><a href = "Index.PHP">CV Creation Software</a></h1>
	<h1>Create Account</h1>
	<?php
		require "Config.PHP";
		$error = '';
		if(isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['pass']))
		{
			$username = htmlspecialchars($_POST['username']);
			$password = htmlspecialchars($_POST['pass']);

			$sql = "INSERT INTO `users` (`Username`, `Password`, `Admin`)
					VALUES ('$username', '$password', '0')";

			if($conn->query($sql) === TRUE)
			{
				//echo "Created Successfully";
				$_SESSION['admin'] = FALSE;
				$_SESSION['login_user'] = $username;
				$_SESSION['logged_in'] = TRUE;
				header("Location: SuccessfulLogin.PHP");
				$conn->close();
				exit();
			}else
			{
				// if duplicate username, this will say so
				$error = 'Username taken';
			}
		}else
		{
			$error = 'Please enter a username and password';
		}
	?>
	<form class="login_form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
		Username:<br>
		<input type = "text" name = "username" required><br>
		Password:<br>
		<input type = "password" name = "pass" required>
		<input type = "submit" value = "Submit" name = "submit">
		<input type = "reset" value = "Clear">
		<h4 class = "error"><?php echo $error; ?></h4>
	</form>
	<p>Already have an account? <a href = "Login.PHP">Login here</a></p>
</body>
</html>