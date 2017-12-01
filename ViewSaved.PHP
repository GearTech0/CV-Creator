<!DOCTYPE html>
<html lang="en-US">
<?php
    session_set_cookie_params(0);
    session_start();
?>
<html>
<head>
	<title>CV Creation Software</title>
	<link rel="stylesheet" href="css/ViewSavedPage.css">
</head>
<body>
	<h1><a href = "Index.PHP">CV Creation Software</a></h1>
    <h2>Saved Templates</h2>
    <h3>Your saved CVs:</h3>
    <form action="CreateCV.php" method="post">
    	<?php
	    	require "Config.PHP";
			/**
			* List all of the cvs the user has in this database
      * No parameters
      * No return values
			*/
			$sql = "SELECT `CVName` FROM " . $_SESSION['login_user'] . "_previous_cv";
			$result = $conn->query($sql);

			if($result->num_rows > 0)
			{
				while($row = $result->fetch_assoc()) {
					echo '<input type="radio" name="cv" value="' . $row['CVName'] . '"checked>' . $row['CVName'] . '<br>';
				}
        echo '<br>';
      	echo '<input type="submit" name="create" value="Create Selected">';
			}else
      {
        echo '<h4>You have no CVs, <a href="NameCV.php">create one</a></h4>';
      }

			$conn->close();
    	?>

	</form>
</body>
</html>
