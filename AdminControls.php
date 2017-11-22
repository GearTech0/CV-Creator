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
		$error = '';

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

			if($conn->query($sql) === TRUE)
			{
				$error1 = 'Successfully added user, refresh page to see in table';
				$conn->close();
				//header("Refresh:0");
			}else
			{
				// if duplicate username, this will say so
				$error1 = 'Username taken';
			}
		}else
		{
			$error1 = 'Please enter a username and password';
		}

		if(isset($_POST['submitUpdate']) && !empty($_POST['usernameUpdate']))
		{
			$username = htmlspecialchars($_POST['usernameUpdate']);
			if(isset($_POST['passUpdate']))
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
				}
			}
			
			if(isset($_POST['adminUpdate']))
			{
				// updating user admin
				$password = htmlspecialchars($_POST['passUpdate']);
				$sql = "UPDATE users SET Admin=1 WHERE Username='$username'";
				$result = $conn->query($sql);

				if($conn->query($sql) === TRUE)
				{
					$error2 = "<br>" . $error2 . 'Successfully updated user' . $username . ' admin';
				}else
				{
					// if duplicate username, this will say so
					$error2 = $error2 . '<br>An error occurred while updating admin';
				}
			}

			$error2 = $error2 . '<br>Refresh page to see any changes';
			$conn->close();
			//header("Refresh:0");
		}else
		{
			$error2 = 'Please enter a username to update';
			//header("Refresh:0");
		}

		if(isset($_POST['submitDelete']) && !empty($_POST['usernameDel']))
		{
			$username = htmlspecialchars($_POST['usernameDel']);
			$sql = "DELETE FROM users WHERE Username='$username'";
			$result = $conn->query($sql);

			if($conn->query($sql) === TRUE)
			{
				$error3 = 'Successfully deleted user ' . $username . '. Refresh page to see changes';
			}else
			{
				// if duplicate username, this will say so
				$error3 = 'An error occurred while deleting user ' . $username;
			}
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
	<p>Note: If updating a user with admin privileges, and you would like to keep those privileges, make sure the Admin checkbox is checked</p>
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