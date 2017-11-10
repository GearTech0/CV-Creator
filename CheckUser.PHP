<?php
	require "Config.PHP";
	if(isset($_POST['submit']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$sql = "";
	    $stmt = mysqli_prepare($sql);
	    $stmt->execute();
	    $mysqli->close();
	}
?>