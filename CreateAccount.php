<!DOCTYPE html>
<html lang="en-US">
<?php 
	session_set_cookie_params(0);
	session_start(); 
?>
<html>
<head>
	<title>CV Creation Software</title>
	<link rel="stylesheet" href="css/login.css">
</head>
<body>
	<h1><a href = "Index.PHP">CV Creation Software</a></h1>
	<h1>Create Account</h1>
	<?php
		require "Config.PHP";
		$error = '';

		if(isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['pass']))
		{
			$username = htmlspecialchars($_POST['username']);
			$password = htmlspecialchars($_POST['pass']);

			$sql = "INSERT INTO `users` (`Username`, `Password`, `Admin`)
					VALUES ('$username', '$password', '0')";

			if($conn->query($sql))
			{
				//echo "Created Successfully";
				$_SESSION['admin'] = FALSE;
				$_SESSION['login_user'] = $username;
				$_SESSION['logged_in'] = TRUE;
				header("Location: SuccessfulLogin.PHP");
			}else
			{
				// if duplicate username, this will say so
				$error = 'Username taken';
				exit();
			}
			/* Each cell needs:
			*	width (if 0, extend to right margin)
			*	height
			*	text
			*	border (0 no border, 1 border)(L left, T top, R right, B bottom)
			*	ln (0 right, 1 next line, 2 below)
			*	align ('' left align, L left align, C center align, R right align)
			*	fill (true or false)
			* 	color (hex value, 7 character varchar)
			*	font
			*	style ('U' underline, 'I' italics, 'B' bold)
			*	size
			*/
			// Add a template table for each user
			$sql = "CREATE TABLE {$username}_templates (
				ThemeName VARCHAR(15) PRIMARY KEY
			);";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme table: ' . $conn->connect_error;
				exit();
			}

			// add boxes and box variables
			for($x = 1; $x < 31; $x++)
			{
				$sql = "ALTER TABLE {$username}_templates
						ADD (box" . $x . " TINYINT(1) DEFAULT 0,
							box" . $x . "width INT DEFAULT 0,
							box" . $x . "height INT DEFAULT 0,
							box" . $x . "text VARCHAR(100) DEFAULT '' NOT NULL,
							box" . $x . "border TINYINT(1) DEFAULT 0,
							box" . $x . "ln INT DEFAULT 1,
							box" . $x . "align CHAR(1) DEFAULT 'L',
							box" . $x . "fill BOOLEAN DEFAULT false,
							box" . $x . "color VARCHAR(7) DEFAULT '#FFFFFF',
							box" . $x . "font VARCHAR(12) DEFAULT 'Times',
							box" . $x . "style CHAR(1) DEFAULT '',
							box" . $x . "size INT DEFAULT 10,
							box" . $x . "title TINYINT(1) DEFAULT 0,
							box" . $x . "subtitle TINYINT(1) DEFAULT 0,
							box" . $x . "multi TINYINT(1) DEFAULT 0,
							box" . $x . "padding INT DEFAULT 0
						);";
				if(!$conn->query($sql))
				{
					$error = 'Error creating theme table: ' . $conn->connect_error;
					exit();
				}
			}

			//**************** Add Default Template theme-01 ****************//
			$sql = "INSERT INTO {$username}_templates (ThemeName) VALUES ('theme-01');";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-01: ' . $conn->connect_error;
				exit();
			}
			// theme-01 requires boxes 1-26
			for($x = 1; $x < 27; $x++)
			{
				$sql = "UPDATE {$username}_templates
						SET box".$x."=1, box".$x."width=20, box".$x."height=10, box".$x."border=0, box".$x."ln=1,
							box".$x."align='L', box".$x."fill=0
						WHERE ThemeName='theme-01';";
				if(!$conn->query($sql))
				{
					$error = 'Error creating theme table: ' . $conn->connect_error;
					exit();
				}
			}
			// set titles for sections in boxes 1, 8, 15, 22
			$sql = "UPDATE {$username}_templates
					SET box1text='Personal Information', box8text='Employment History', box15text='Education', box22text='Professional Qualifications',
					box1title=1, box8title=1, box15title=1, box22title=1,
					box1padding=2, box8padding=2, box15padding=2, box22padding=2
					WHERE ThemeName='theme-01';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-01: ' . $conn->connect_error;
				exit();
			}
			// set subtitles for sections in boxes 2, 4, 6, 9, 11, 13, 16, 18, 20, 23, 25
			$sql = "UPDATE {$username}_templates
					SET box2text='Name', box4text='Phone Number', box6text='Email', box9text='Work History', 
					box11text='Academic Position', box13text='Research and Training', box16text='University Attended',
					box18text='Degree', box20text='Major', box23text='Certifications', box25text='Accreditations',
					box2subtitle=1, box4subtitle=1, box6subtitle=1, box9subtitle=1, box11subtitle=1, box13subtitle=1, box16subtitle=1, box18subtitle=1,
					box20subtitle=1, box23subtitle=1, box25subtitle=1
					WHERE ThemeName='theme-01';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-01: ' . $conn->connect_error;
				exit();
			}
			// set box texts
			$sql = "UPDATE {$username}_templates
					SET box3text='name', box5text='phone', box7text='email',
						box10text='WorkHistory', box12text='AcaPosition', box14text='Reasearch', 
						box17text='University', box19text='Degree', box21text='Major',
						box24text='Certs', box26text='Accreds',
						box10multi=1, box12multi=1, box14multi=1, box24multi=1, box26multi=1
					WHERE ThemeName='theme-01';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-01: ' . $conn->connect_error;
				exit();
			}
			// set title/subtitle text size
			$sql = "UPDATE {$username}_templates
					SET box1size=14, box8size=14, box15size=14, box20size=14,
						box2size=12, box4size=12, box6size=12, box9size=12, box11size=12, box13size=12, box16size=12, box18size=12,
						box20size=12, box23size=12, box25size=12
					WHERE ThemeName='theme-01';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-01: ' . $conn->connect_error;
				exit();
			}
			//**************** End Default Template theme-01 ****************//

			// Add a previous cv table for each user
			$sql = "CREATE TABLE {$username}_previous_cv (
				CVName VARCHAR(255) PRIMARY KEY,

				Name VARCHAR(30) DEFAULT '',
				Phone VARCHAR(15) DEFAULT '',
				Email VARCHAR(50) DEFAULT '',
				WorkHistory TEXT(65532) DEFAULT '' NOT NULL,
				Academic TEXT(65532) DEFAULT '' NOT NULL,
				Research TEXT(65532) DEFAULT '' NOT NULL,
				University VARCHAR(255) DEFAULT '',
				Degree VARCHAR(255) DEFAULT '',
				Major VARCHAR(50) DEFAULT '',
				Certs TEXT(65532) DEFAULT '' NOT NULL,
				Accreds TEXT(65532) DEFAULT '' NOT NULL
			);";
			if(!$conn->query($sql))
			{
				$error = 'Error creating previous cv table: ' . $conn->connect_error;
				exit();
			}
		}else
		{
			$error = 'Please enter a username and password';
		}
	?>
	<form class="login_form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
		Username:<br>
		<input type = "text" name = "username" required><br>
		Password:<br>
		<input type = "password" name = "pass" required>
		<input type = "submit" value = "Submit" name = "submit">
		<input type = "reset" value = "Clear">
		<h4 class = "error"><?php echo $error; ?></h4>
	</form>
	<p>Already have an account? <a href = "Login.PHP">Login here</a></p>
</body>
</html>
