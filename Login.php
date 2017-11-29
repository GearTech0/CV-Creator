<!DOCTYPE html>
<html lang="en-US">
<?php 
	session_set_cookie_params(0);
	session_start(); 
?>
<html>
<head>
	<title>CV Creation Software</title>
	<link rel="stylesheet" href="css/LoginPage.css">
</head>
<body>
	<h1><a href = "Index.PHP">CV Creation Software</a></h1>
	<h1>Login</h1>
	<?php
		require "Config.PHP";
		$error = '';
		if(isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['pass']))
		{
			$username = htmlspecialchars($_POST['username']);
			$password = htmlspecialchars($_POST['pass']);

			$sql = "SELECT Admin FROM users WHERE Username = '$username'  AND Password = '$password'";
			$result = $conn->query($sql);

			if($result->num_rows > 0)
			{
				// success
				while($row = $result->fetch_assoc())
				{
					$admin = $row["Admin"];
				}
				if($admin) $_SESSION['admin'] = TRUE;
				else $_SESSION['admin'] = FALSE;
				$_SESSION['logged_in'] = TRUE;
				$_SESSION['login_user'] = $username;
				header("Location: SuccessfulLogin.PHP");
				$conn->close();
				exit();
			}else
			{
				// no such account
				$error = 'Incorrect username or password!';
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
		<input type = "password" name = "pass" required><br>
		<input type = "submit" name = "submit" value = "Submit">
		<input type = "reset" value = "Clear">
		<h4 class = "error"><?php echo $error; ?></h4>
	</form>
	<p>Don't have an account? <a href = "CreateAccount.PHP">Create one</a></p>
</body>
</html>
