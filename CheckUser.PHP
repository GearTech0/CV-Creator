<?php
	require "Config.PHP";
	if(isset($_POST['submit']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];

		$sql = "SELECT `UserID` FROM `users` WHERE `Username` = '$username'";
		$result = $conn->query($sql);

		if($result->num_rows > 0)
		{
			// success
			session_start();
			$_SESSION['login_user'] = $username;
			header("Location: SuccessfulLogin.PHP");
			$conn->close();
			exit();
		}else
		{
			// no such account
			header("Location: Login.PHP");
		}

		$conn->close();
	}
?>