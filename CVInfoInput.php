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
	<title>CV Creation Software - Input</title>
	<link rel="stylesheet" href="css/inputPage.css">
</head>
	<h1><a href = "Index.PHP">CV Creation Software</a></h1>
	<h2>CV Information Input</h2>
	<h3>Personal Information</h3>

	<form action="CreateCV.php" method="post">
		Name:<br>
		<input type="text" name="name"><br>
		Phone Number:<br>
		<input type="tel" name="phone"><br>
		Email:<br>
		<input type="email" name="email"><br>


		<h3>Employment History</h3>
		Work History:<br>
		<textarea form = "EmploymentHistoryForm" name="WorkHistory" rows="10" cols="50" placeholder="Enter work history here..">
		</textarea><br>
		Academic Position:<br>
		<textarea form = "EmploymentHistoryForm" name="AcaPosition" rows="10" cols="50" placeholder="Enter academic position here..">
		</textarea><br>
		Research and Training:<br>
		<textarea form = "EmploymentHistoryForm" name="Reasearch" rows="10" cols="50" placeholder="Enter any research or training here..">
		</textarea><br>


		<h3>Education</h3>
			University Attended:<br>
			<input type="text" name="University"><br>
			Degree:<br>
			<input type="text" name="Degree"><br>
			Major:<br>
			<input type="text" name="Major"><br>


		<h3>Professional Qualifications</h3>
			Certifications:<br>
			<textarea form="QualificationsForm" name="Certs" rows="10" cols="50" placeholder="Enter certifications here..">
			</textarea><br>
			Accreditations:<br>
			<textarea form="QualificationsForm" name="Accreds" rows="10" cols="50" placeholder="Enter accreditations here..">
			</textarea><br>


		<h3>Choose Template</h3>
		<table>
			<tr>
				<td>
            		<img src="images/placeholder.jpg" alt="template1">
            		<figcaption>Template 1</figcaption>
        		</td>
				<td>
            		<img src="images/placeholder.jpg" alt="template2">
            		<figcaption>Template 2</figcaption>
				</td>
				<td>
            		<img src="images/placeholder.jpg" alt="template3">
            		<figcaption>Template 3</figcaption>
				</td>
			</tr>
			<tr>
				<td>
            		<img src="images/placeholder.jpg" alt="template4">
            		<figcaption>Template 4</figcaption>
				</td>
				<td>
            		<img src="images/placeholder.jpg" alt="template5">
            		<figcaption>Template 5</figcaption>
				</td>
			</tr>
		</table>

		<?php
			require "Config.PHP";
			/**
			* List all of the templates the user has in this database
			*/
			$sql = "SELECT `ThemeName` FROM " . $_SESSION['login_user'] . "_templates";
			$result = $conn->query($sql);

			if($result->num_rows > 0)
			{
				while($row = $result->fetch_assoc()) {
					echo '<input type="radio" name="template" value="' . $row['ThemeName'] . '"checked>' . $row['ThemeName'] . '<br>';
				}
			}

			$conn->close();
		?><br>
		<input type="checkbox" name="pdfChoose" value="Download as PDF?" checked>Download CV as PDF?<br><br>

		<h4 class = "error"><?php echo $error; ?></h4>

		<input type="submit" name="submit" value="Save">
	</form>
</html>
