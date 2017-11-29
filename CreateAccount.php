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

			if($conn->query($sql))
			{
				//echo "Created Successfully";
				$_SESSION['admin'] = FALSE;
				$_SESSION['login_user'] = $username;
				$_SESSION['logged_in'] = TRUE;
				header("Location: SuccessfulLogin.PHP");
			}else
			{
				// if duplicate username, this will say so
				$error = 'Username taken';
				exit();
			}

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

			// Add a previous cv table for each user
			$sql = "CREATE TABLE {$username}_previous_cv (
				CVName VARCHAR(255) PRIMARY KEY,

				Name VARCHAR(30) DEFAULT '',
				Phone VARCHAR(15) DEFAULT '',
				Email VARCHAR(50) DEFAULT '',
				WorkHistory TEXT(65532) DEFAULT '' NOT NULL,
				Academic TEXT(65532) DEFAULT '' NOT NULL,
				Research TEXT(65532) DEFAULT '' NOT NULL,
				University VARCHAR(255) DEFAULT '',
				Degree VARCHAR(255) DEFAULT '',
				Major VARCHAR(50) DEFAULT '',
				Certs TEXT(65532) DEFAULT '' NOT NULL,
				Accreds TEXT(65532) DEFAULT '' NOT NULL
			);";
			if(!$conn->query($sql))
			{
				$error = 'Error creating previous cv table: ' . $conn->connect_error;
				exit();
			}

			// Add Default Template theme-01
			$sql = "INSERT INTO {$username}_templates VALUES (
				'theme-01',
				0, 0, '#000000', '#FFFFFF', 12, 'TIMES',
				0, 0, '#000000', '#FFFFFF', 12, 'TIMES',
				0, 0, '#000000', '#FFFFFF', 12, 'TIMES'
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
		<input type = "submit" value = "Submit" name = "submit">
		<input type = "reset" value = "Clear">
		<h4 class = "error"><?php echo $error; ?></h4>
	</form>
	<p>Already have an account? <a href = "Login.PHP">Login here</a></p>
</body>
</html>
