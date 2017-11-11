<?php
	require "Config.PHP";
	if(isset($_POST['submit']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];

		$sql = "INSERT INTO `users` (`Username`, `Password`, `Admin`)
				VALUES ('$username', '$password', '1')";

		if($conn->query($sql) === TRUE)
		{
			//echo "Created Successfully";
			session_start();
			$_SESSION['login_user'] = $username;
			header("Location: SuccessfulLogin.PHP");
			exit();
		}else
		{
			// if duplicate username, this will say so
			echo "Error: " . $sql . "<br>" . $conn->error;
			header("Location: CreateAccount.PHP");
		}

		$conn->close();
	}
?>