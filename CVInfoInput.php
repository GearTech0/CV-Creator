<!DOCTYPE html>
<html lang="en-US">
<?php
	session_set_cookie_params(0);
	session_start();
	if(!isset($_SESSION['login_user']))
	{
		header("Location: Login.PHP");
		exit();
	}
	if(!isset($_SESSION['currentCV']))
	{
		header("Location: NameCV.php");
	}
?>
<html>
<head>
	<title>CV Creation Software - Input</title>
	<link rel="stylesheet" href="css/inputPage.css">
</head>
	<h1><a href = "Index.PHP">CV Creation Software</a></h1>
	<h2>CV Information Input</h2>
	<h2>Editing CV: <?php echo $_SESSION['currentCV'] ?></h2>
	<h3>Personal Information</h3>
	<?php
		require "Config.PHP";
		$table = $_SESSION['login_user'] . '_previous_cv';
		$sql = "SELECT * FROM `" . $table . "` WHERE CVName = '" . $_SESSION['currentCV'] . "'";
		$result = $conn->query($sql);
		if($result)
		{
			while($row = $result->fetch_assoc())
			{
				?>
				<form action="CreateCV.php" method="post">
					Name:<br>
					<input type="text" name="name" value="<?php echo(htmlspecialchars($row['Name']));?>"><br>
					Phone Number:<br>
					<input type="tel" name="phone" value="<?php echo(htmlspecialchars($row['Phone']));?>"><br>
					Email:<br>
					<input type="email" name="email" value="<?php echo(htmlspecialchars($row['Email']));?>"><br>


					<h3>Employment History</h3>
					Work History:<br>
					<textarea name="WorkHistory" rows="10" cols="50"><?php echo(htmlspecialchars($row['WorkHistory']));?>
					</textarea><br>
					Academic Position:<br>
					<textarea name="AcaPosition" rows="10" cols="50"><?php echo(htmlspecialchars($row['Academic']));?>
					</textarea><br>
					Research and Training:<br>
					<textarea name="Reasearch" rows="10" cols="50"><?php echo(htmlspecialchars($row['Research']));?>
					</textarea><br>


					<h3>Education</h3>
						University Attended:<br>
						<input type="text" name="University" value="<?php echo(htmlspecialchars($row['University']));?>"><br>
						Degree:<br>
						<input type="text" name="Degree" value="<?php echo(htmlspecialchars($row['Degree']));?>"><br>
						Major:<br>
						<input type="text" name="Major" value="<?php echo(htmlspecialchars($row['Major']));?>"><br>


					<h3>Professional Qualifications</h3>
						Certifications:<br>
						<textarea name="Certs" rows="10" cols="50" ><?php echo(htmlspecialchars($row['Certs']));?>
						</textarea><br>
						Accreditations:<br>
						<textarea name="Accreds" rows="10" cols="50"><?php echo(htmlspecialchars($row['Accreds']));?>
						</textarea><br>


					<h3>Choose Template</h3>
					<table>
						<tr>
							<td>
			            		<img src="images/theme-01.jpg" alt="template1">
			            		<figcaption>Template 1</figcaption>
			        		</td>
							<td>
			            		<img src="images/theme-02.jpg" alt="template2">
			            		<figcaption>Template 2</figcaption>
							</td>
							<td>
			            		<img src="images/theme-03.jpg" alt="template3">
			            		<figcaption>Template 3</figcaption>
							</td>
						</tr>
						<tr>
							<td>
			            		<img src="images/theme-04.jpg" alt="template4">
			            		<figcaption>Template 4</figcaption>
							</td>
							<td>
			            		<img src="images/theme-05.jpg" alt="template5">
			            		<figcaption>Template 5</figcaption>
							</td>
							<td>
			            		<img src="images/theme-06.jpg" alt="template6">
			            		<figcaption>Template 6</figcaption>
							</td>
						</tr>
						<tr>
							<td>
			            		<img src="images/theme-07.jpg" alt="template7">
			            		<figcaption>Template 7</figcaption>
							</td>
							<td>
			            		<img src="images/theme-08.jpg" alt="template8">
			            		<figcaption>Template 8</figcaption>
							</td>
							<td>
			            		<img src="images/theme-09.jpg" alt="template9">
			            		<figcaption>Template 9</figcaption>
							</td>
						</tr>
						<tr>
							<td>
			            		<img src="images/theme-10.jpg" alt="template10">
			            		<figcaption>Template 10</figcaption>
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
					?><br>
					<input type="checkbox" name="pdfChoose" value="Download as PDF?" checked>Download CV as PDF?<br><br>
					<input type="submit" name="save" value="Save">
					<input type="submit" name="submit" value="Create">
				</form>
				<?php
			}
			$conn->close();
			exit();
		}else
		{
			$error = "Something went wrong";
			$conn->close();
		}
	?>
	<h4 class = "error"><?php echo $error; ?></h4>
</html>
