<!DOCTYPE html>
<html lang="en-US">
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
			//Create User
			$username = $_POST['username'];
			$password = $_POST['pass'];

			// Add a template table for each user
			$sql = "CREATE TABLE {$username}_templates (
				ThemeName VARCHAR(15) PRIMARY KEY,

				header_x INT,
				header_y INT,
				header_color VARCHAR(7),
				header_bgcolor VARCHAR(7),
				header_fontsize INT,
				header_font VARCHAR(15),

				body_x INT,
				body_y INT,
				body_color VARCHAR(7),
				body_bgcolor VARCHAR(7),
				body_fontsize INT,
				body_font VARCHAR(15),

				footer_x INT,
				footer_y INT,
				footer_color VARCHAR(7),
				footer_bgcolor VARCHAR(7),
				footer_fontsize INT,
				footer_font VARCHAR(15)
			);";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme table: ' . $conn->connect_error;
				exit();
			}

			// Add Default Template theme-01
			$sql = "INSERT INTO {$username}_templates VALUES (
				'theme-01',
				0, 0, '#000000', '#FFFFFF', 15, 'TIMES',
				0, 0, '#000000', '#FFFFFF', 15, 'TIMES',
				0, 0, '#000000', '#FFFFFF', 15, 'TIMES'
			);";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-01: ' . $conn->connect_error;
				exit();
			}

		 // Add Default Template theme-01
			$sql = "INSERT INTO {$username}_templates VALUES (
				'theme-02',
				0, 0, '#000000', '#48A49B', 15, 'ARIAL',
				0, 0, '#000000', '#48A49B', 15, 'ARIAL',
				0, 0, '#000000', '#48A49B', 15, 'ARIAL'
			);";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-02: ' . $conn->connect_error;
				exit();
			}

			$sql = "INSERT INTO `users` (`Username`, `Password`, `Admin`)
					VALUES ('$username', '$password', '0')";

			if($conn->query($sql) === TRUE)
			{
				session_start();
				$_SESSION['login_user'] = $username;
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
