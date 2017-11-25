<!DOCTYPE html>
<html lang="en-US">
<?php
	session_set_cookie_params(0);
	session_start();
	if(!$_SESSION['admin'] || empty($_SESSION['admin']))
	{
		// User is not an admin, cannot access this page
		header("Location: Index.php");
	}
?>
<html>
<head>
	<title>CV Creation Software</title>
	<link rel="stylesheet" href="css/admin.css">
</head>
<body>
	<h1><a href = "Index.PHP">CV Creation Software</a></h1>
	<h2>Admin Tools</h2>
    <?php
		require "Config.PHP";

		$sql = "SELECT * FROM users";
		$result = $conn->query($sql);
		echo "<table>
				<tr>
				<th>Username</th>
				<th>Admin</th>
				<tr>";
		while($row = $result->fetch_assoc())
		{
			echo "<tr>";
			echo "<td>" . $row['Username'] . "</td>";
			echo "<td>" . $row['Admin'] . "</td>";
			echo "</tr>";
		}

		echo "</table>";
		$conn->close();
	?>
	<?php
		require "Config.PHP";
		$error1 = '';
		$error2 = '';
		$error3 = '';
		if(isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['pass']))
		{
			$username = htmlspecialchars($_POST['username']);
			$password = htmlspecialchars($_POST['pass']);
			if(isset($_POST['admin']))
			{
				$sql = "INSERT INTO `users` (`Username`, `Password`, `Admin`)
					VALUES ('$username', '$password', '1')";
			}else
			{
				$sql = "INSERT INTO `users` (`Username`, `Password`, `Admin`)
					VALUES ('$username', '$password', '0')";
			}

			if($conn->query($sql))
			{
				//echo "Created Successfully";
				$error1 = 'Created user ' . $username . ' successfully';
			}else
			{
				// if duplicate username, this will say so
				$error1 = 'Username taken';
				$conn->close();
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
				$error1 = 'Error creating theme table: ' . $conn->connect_error;
				$conn->close();
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
				$error1 = 'Error creating previous cv table: ' . $conn->connect_error;
				$conn->close();
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
				$error1 = 'Error creating theme-01: ' . $conn->connect_error;
				$conn->close();
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
				$error1 = 'Error creating theme-02: ' . $conn->connect_error;
				$conn->close();
				exit();
			}
			header("Refresh:0");
			exit();
		}else
		{
			$error1 = 'Please enter a username and password';
		}

		if(isset($_POST['submitUpdate']) && !empty($_POST['usernameUpdate']))
		{
			$username = htmlspecialchars($_POST['usernameUpdate']);
			if($_POST['passUpdate'] !== '')
			{
				// updating a user password
				$password = htmlspecialchars($_POST['passUpdate']);
				$sql = "UPDATE users SET Password='$password' WHERE Username='$username'";
				$result = $conn->query($sql);

				if($conn->query($sql) === TRUE)
				{
					$error2 = 'Successfully updated user ' . $username . ' password';
				}else
				{
					// if duplicate username, this will say so
					$error2 = 'An error occurred while updating pass';
					$conn->close();
					exit();
				}
			}
			
			if(isset($_POST['adminUpdate']))
			{
				// updating user admin
				$password = htmlspecialchars($_POST['passUpdate']);
				$sql = "UPDATE users SET Admin=1 WHERE Username='$username'";
				$result = $conn->query($sql);

				if($conn->query($sql))
				{
					$error2 = "<br>" . $error2 . 'Successfully updated user' . $username . ' admin';
				}else
				{
					// if duplicate username, this will say so
					$error2 = $error2 . '<br>An error occurred while updating admin';
					$conn->close();
					exit();
				}
			}

			$error2 = $error2 . '<br>Refresh page to see any changes';
			$conn->close();
			header("Refresh:0");
			exit();
		}else
		{
			$error2 = 'Please enter a username to update';
		}

		if(isset($_POST['submitDelete']) && !empty($_POST['usernameDel']))
		{
			$username = htmlspecialchars($_POST['usernameDel']);
			if($username === $_SESSION['login_user'])
			{
				$error3 = "Don't delete yourself";
				$conn->close();
				exit();
			}
			$sql = "DELETE FROM users WHERE Username='$username'";
			$result = $conn->query($sql);

			if($result)
			{
				$error3 = 'Successfully deleted user ' . $username . '. Refresh page to see changes';
			}else
			{
				// if duplicate username, this will say so
				$error3 = 'An error occurred while deleting user ' . $username;
				$conn->close();
				exit();
			}

			$sql = "DROP TABLE {$username}_previous_cv";
			$result = $conn->query($sql);
			if(!$result)
			{
				$error3 = 'Error deleting previous cv table';
				$conn->close();
				exit();
			}

			$sql = "DROP TABLE {$username}_templates";
			$result = $conn->query($sql);
			if(!$result)
			{
				$error3 = 'Error deleting templates table';
				$conn->close();
				exit();
			}
			header("Refresh:0");
			exit();
		}
	?>
	<h3>Add User</h3>
	<form class="login_form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
		Username:<br>
		<input type = "text" name = "username" required><br>
		Password:<br>
		<input type = "password" name = "pass" required><br>
		<input type = "checkbox" name = "admin" value ="Admin">Admin<br>
		<input type = "submit" value = "Submit" name = "submit">
		<input type = "reset" value = "Clear">
		<h4 class = "error"><?php echo $error1; ?></h4>
	</form>
	<h3>Update User</h3>
	<form class="update_form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
		Username:<br>
		<input type = "text" name = "usernameUpdate" required><br>
		New Password:<br>
		<input type = "password" name = "passUpdate"><br>
		<input type = "checkbox" name = "adminUpdate" value ="Admin">Admin<br>
		<input type = "submit" value = "Submit" name = "submitUpdate">
		<input type = "reset" value = "Clear">
		<h4 class = "error"><?php echo $error2; ?></h4>
	</form>
	<h3>Delete User</h3>
	<p>Note: This permanently deletes a user, be careful</p>
	<form class="delete_form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
		Username:<br>
		<input type = "text" name = "usernameDel" required><br>
		<input type = "submit" value = "Submit" name = "submitDelete">
		<input type = "reset" value = "Clear">
		<h4 class = "error"><?php echo $error3; ?></h4>
	</form>
</body>
</html>