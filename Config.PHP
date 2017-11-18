<?php
	$server = 'localhost';
	$dbUsername = 'root';
	$dbPassword = 'root';
	$db = 'test';
	$conn = new mysqli($server, $dbUsername, $dbPassword, $db);

	if($conn->connect_error)
	{
		die("Connection error: " . $conn->connect_error);
	}

?>
