<!DOCTYPE html>
<html lang="en-US">
<?php
    session_set_cookie_params(0);
	session_start();
	if(!isset($_SESSION['login_user']))
	{
		header("Location: Login.PHP");
	}
?>
<html>
<head>
	<title>CV Creation Software</title>
	<link rel="stylesheet" href="css/homestyles.css">
</head>
<body>
	<h1><a href = "Index.PHP">CV Creation Software</a></h1>
    <h2>Edit Saved CV</h2>
    <h3>Your saved CVs:</h3>
    <?php
    	require "Config.PHP";
		/**
		* List all of the cvs the user has in this database
		*/
		$sql = "SELECT `CVName` FROM " . $_SESSION['login_user'] . "_previous_cv";
		$result = $conn->query($sql);

		if($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc()) {
				echo '<input type="radio" name="cv" value="' . $row['CVName'] . '"checked>' . $row['CVName'] . '<br>';
			}
		}

		$conn->close();

    ?>
</body>
</html>