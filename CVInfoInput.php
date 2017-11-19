<!DOCTYPE html>
<html lang="en-US">
<?php
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

	<?php

		require "includes/fpdf181/fpdf.php";	// Grab PDF generation library

		/**
		* CreateCV
		* Writes $report information .PDF based on $theme specifications
		*
		*
		* $theme array specifications on how the PDF will look
		*	array(
		*		header => array(
		*			x => int,
		*			y => int,
		*			color => string, //hexcode
		*			backgroundcolor => string, //hexcode
		*			fontsize => int
		*		),
		*		body => array(
		*			x => int,
		*			y => int,
		*			color => string, //hexcode
		*			backgroundcolor => string, //hexcode
		*			fontsize => int
		*		),
		*		footer => array(
		*			x => int,
		*			y => int,
		*			color => string, //hexcode
		*			backgroundcolor => string, //hexcode
		*			fontsize => int
		*		)
		*	)
		* $report array information to write to PDF
		*	array(
		*		name => string,
		*		number => string,
		*		email => string
		*	)
		*/
		function CreateCV($theme, $report)
		{
			$pdf = new FPDF();
			$pdf->AddPage();
			$pdf->SetFont($theme['header']['font'], '', $theme['header']['fontsize']);

			// Create Header if CV
			$pdf->Cell(80);
			$pdf->Cell(10,5,$report['name'],0,1,'C');
			$pdf->Cell(80);
			$pdf->Cell(10,5,$report['phone'],0,1,'C');
			$pdf->Cell(80);
			$pdf->Cell(10,5,$report['email'],0,1,'C');


			$pdf->Output();
		}

		/**
		* GetTheme
		* Retrieve theme '$themeName' from database
		*
		*
		* $themeName string name of the theme
		* return array theme array
		*/
		function GetTheme($themeName, $username)
		{
			require "Config.PHP";
			// Query DB for theme information
			$sql = "SELECT * FROM `{$username}_templates` WHERE `ThemeName`='$themeName'";
			$result = $conn->query($sql);

			if($result->num_rows > 0)
			{
				while($row = $result->fetch_assoc()) {
					// Set theme information into theme array in respective positions
					$theme = [
						'header' => [
							'x' => $row['header_x'],
							'y' => $row['header_y'],
							'color' => $row['header_color'],
							'backgroundcolor' => $row['header_bgcolor'],
							'fontsize' => $row['header_fontsize'],
							'font' => $row['header_font']
						],
						'body' => [
							'x' => $row['body_x'],
							'y' => $row['body_y'],
							'color' => $row['body_color'],
							'backgroundcolor' => $row['body_bgcolor'],
							'fontsize' => $row['body_fontsize'],
							'font' => $row['body_font']
						],
						'footer' => [
							'x' => $row['footer_x'],
							'y' => $row['footer_y'],
							'color' => $row['footer_color'],
							'backgroundcolor' => $row['footer_bgcolor'],
							'fontsize' => $row['footer_fontsize'],
							'font' => $row['footer_font']
						]
					];
				}
			}
			else
			{
					$error = "There are no templates available to this user.";
			}

			// Return the theme array
			return $theme;
		}

		if(!isset($_SESSION['login_user']))
		{
			// Not logged in
			echo "You are not logged in. Please <a href=\"Login.php\">Log In</a> to do this action.";
			exit();
		}
		else if(isset($_POST['submit']) && isset($_POST['name']) && isset($_POST['phone']))
		{

			// Get the theme to use for the CV
			$theme = GetTheme('theme-01', $_SESSION['login_user']);

			$report = [
				'name' => htmlspecialchars($_POST['name']),
				'phone' => htmlspecialchars($_POST['phone']),
				'email' => htmlspecialchars($_POST['email']),

				'WorkHistory' => htmlspecialchars($_POST['WorkHistory']),
				'AcaPosition' => htmlspecialchars($_POST['AcaPosition']),
				'Reasearch' => htmlspecialchars($_POST['Reasearch']),

				'UniversityUniversity' => htmlspecialchars($_POST['University']),
				'Degree' => htmlspecialchars($_POST['Degree']),
				'Major' => htmlspecialchars($_POST['Major']),

				'Certs' => htmlspecialchars($_POST['Certs']),
				'Accreds' => htmlspecialchars($_POST['Accreds']),

				'template' => htmlspecialchars($_POST['template']),
				'pdfChoose' => htmlspecialchars($_POST['pdfChoose'])
			];

			CreateCV($theme, $report, $is_pdf);
		}
	?>

	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
		Name:<br>
		<input type = "text" name="name"><br>
		Phone Number:<br>
		<input type = "tel" name="phone"><br>
		Email:<br>
		<input type="email" name="email"><br>


		<h3>Employment History</h3>
		Work History:<br>
		<textarea form = "EmploymentHistoryForm" name = "WorkHistory" rows = "10" cols = "50" placeholder = "Enter work history here..">
		</textarea><br>
		Academic Position:<br>
		<textarea form = "EmploymentHistoryForm" name = "AcaPosition" rows = "10" cols = "50" placeholder = "Enter academic position here..">
		</textarea><br>
		Research and Training:<br>
		<textarea form = "EmploymentHistoryForm" name = "Reasearch" rows = "10" cols = "50" placeholder = "Enter any research or training here..">
		</textarea><br>


		<h3>Education</h3>
			University Attended:<br>
			<input type = "text" name = "University"><br>
			Degree:<br>
			<input type = "text" name = "Degree"><br>
			Major:<br>
			<input type = "text" name = "Major"><br>


		<h3>Professional Qualifications</h3>
			Certifications:<br>
			<textarea form = "QualificationsForm" name = "Certs" rows = "10" cols = "50" placeholder = "Enter certifications here..">
			</textarea><br>
			Accreditations:<br>
			<textarea form = "QualificationsForm" name = "Accreds" rows = "10" cols = "50" placeholder = "Enter accreditations here..">
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
			/**
			* List all of the templates the user has in this database
			*/
		?>

		<input type = "radio" name="template" value="template1">Template 1<br>
		<input type = "radio" name="template" value="template2">Template 2<br>
		<input type = "radio" name="template" value="template3">Template 3<br>
		<input type = "radio" name="template" value="template4">Template 4<br>
		<input type = "radio" name="template" value="template5">Template 5<br><br>
		<input type = "checkbox" name="pdfChoose" value="Download as PDF?" checked>Download CV as PDF?<br><br>

		<h4 class = "error"><?php echo $error; ?></h4>

		<input type="submit" name="submit" value="cv">
	</form>
</html>
