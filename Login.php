<!DOCTYPE html>
<html lang="en-US">
<html>
<head>
	<title>CV Creation Software</title>
	<link rel="stylesheet" href="css/login.css">
</head>
<body>
	<h1><a href = "Index.PHP">CV Creation Software</a></h1>
	<h1>Login</h1>
	<?php
		require "Config.PHP";
		$error = '';
		if(isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['pass']))
		{
			$username = $_POST['username'];
			$password = $_POST['pass'];

			$sql = "SELECT `UserID' FROM `users` WHERE `Username` = '$username' AND `Password` = '$password'";
			$result = $conn->query($sql);

			if($result->num_rows > 0)
			{
				// success
				session_start();
				$_SESSION['logged_in'] = true;
				$_SESSION['login_user'] = $username;
				header("Location: SuccessfulLogin.PHP");
				$conn->close();
				exit();
			}else
			{
				// no such account
				$error = 'Incorrect username or password';
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
		<input type = "submit" name = "submit" value = "Submit">
		<input type = "reset" value = "Clear">
		<h4 class = "error"><?php echo $error; ?></h4>
	</form>
	<p>Don't have an account? <a href = "CreateAccount.PHP">Create one</a></p>
</body>
</html>