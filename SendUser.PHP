<?php
	require "Config.PHP";
	if(isset($_POST['submit']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$sql = "INSERT INTO users (Username, Password, Admin)
				VALUES ($username, $password, 'TRUE')";
	    if(mysqli_query($mysqli, $sql))
	    {
	    	echo "Success";
	    }else
	    {
	    	echo "Error: " . $sql > "<br>" . mysqli_error($mysqli);
	    }
	    $mysqli->close();
	}
?>