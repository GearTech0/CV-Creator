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
			// box" . $x . "borderPlace VARCHAR(4) DEFAULT '',
			// add boxes and box variables
			for($x = 1; $x < 31; $x++)
			{
				$sql = "ALTER TABLE {$username}_templates
						ADD (box" . $x . " TINYINT(1) DEFAULT 0,
							box" . $x . "width INT DEFAULT 0,
							box" . $x . "height INT DEFAULT 0,
							box" . $x . "text VARCHAR(100) DEFAULT '' NOT NULL,
							box" . $x . "border VARCHAR(4) DEFAULT '',

							box" . $x . "ln INT DEFAULT 1,
							box" . $x . "align CHAR(1) DEFAULT 'L',
							box" . $x . "fill BOOLEAN DEFAULT false,
							box" . $x . "color VARCHAR(7) DEFAULT '#FFFFFF',
							box" . $x . "font VARCHAR(12) DEFAULT 'Times',
							box" . $x . "style CHAR(1) DEFAULT '',
							box" . $x . "size INT DEFAULT 10,
							box" . $x . "fontColor VARCHAR(7) DEFAULT '#000000',
							box" . $x . "title TINYINT(1) DEFAULT 0,
							box" . $x . "subtitle TINYINT(1) DEFAULT 0,
							box" . $x . "multi TINYINT(1) DEFAULT 0,
							box" . $x . "padding INT DEFAULT 0,
							box" . $x . "move INT DEFAULT 0
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
						SET box".$x."=1, box".$x."width=20, box".$x."height=10, box".$x."border='0', box".$x."ln=1,
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

			//**************** Add Default Template theme-02 ****************//
			$sql = "INSERT INTO {$username}_templates (ThemeName) VALUES ('theme-02');";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-02: ' . $conn->connect_error;
				exit();
			}
			// theme-02 requires boxes 1-21
			for($x = 1; $x < 22; $x++)
			{
				$sql = "UPDATE {$username}_templates
						SET box".$x."=1, box".$x."width=20, box".$x."height=10, box".$x."border='0', box".$x."ln=1,
							box".$x."align='L', box".$x."fill=0, box".$x."font='Arial'
						WHERE ThemeName='theme-02';";
				if(!$conn->query($sql))
				{
					$error = 'Error creating theme table: ' . $conn->connect_error;
					exit();
				}
			}
			// set titles for sections in boxes 2, 5, 12, 16
			$sql = "UPDATE {$username}_templates
					SET box2text='Personal Information', box5text='Employment History', box12text='Education', box16text='Professional Qualifications',
					box2title=1, box5title=1, box12title=1, box16title=1,
					box2padding=2, box5padding=2, box12padding=2, box16padding=2
					WHERE ThemeName='theme-02';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-02: ' . $conn->connect_error;
				exit();
			}
			// set subtitles for sections in boxes 6, 8, 10, 17, 19
			$sql = "UPDATE {$username}_templates
					SET box6text='Work History', box8text='Academic Position', box10text='Research and Training', 
						box17text='Certifications', box19text='Academic Position', 
						box6subtitle=1, box8subtitle=1, box10subtitle=1, box17subtitle=1, box19subtitle=1
					WHERE ThemeName='theme-02';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-02: ' . $conn->connect_error;
				exit();
			}
			// set title/subtitle text size
			$sql = "UPDATE {$username}_templates
					SET box1size=17,
						box2size=14, box5size=14, box12size=14, box16size=14,
						box6size=12, box8size=12, box10size=12, box17size=12, box19size=12
					WHERE ThemeName='theme-02';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-02: ' . $conn->connect_error;
				exit();
			}
			// set box texts
			$sql = "UPDATE {$username}_templates
					SET box1text='name', box3text='phone', box4text='email',
						box7text='WorkHistory', box9text='AcaPosition', box11text='Reasearch', 
						box13text='University', box14text='Degree', box15text='Major',
						box18text='Certs', box20text='Accreds',
						box7multi=1, box9multi=1, box11multi=1, box18multi=1, box20multi=1
					WHERE ThemeName='theme-02';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-02: ' . $conn->connect_error;
				exit();
			}
			// customizations for theme-02
			$sql = "UPDATE {$username}_templates
					SET box1color='#009999', box21color='#009999',
						box1align='C',
						box1fill=1, box21fill=1,
						box1width=0, box21width=0
					WHERE ThemeName='theme-02';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-02: ' . $conn->connect_error;
				exit();
			}	
			//**************** End Default Template theme-02 ****************//

			//**************** Add Default Template theme-03 ****************//
			$sql = "INSERT INTO {$username}_templates (ThemeName) VALUES ('theme-03');";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-03: ' . $conn->connect_error;
				exit();
			}
			// theme-03 requires boxes 1-21
			for($x = 1; $x < 22; $x++)
			{
				$sql = "UPDATE {$username}_templates
						SET box".$x."=1, box".$x."width=20, box".$x."height=10, box".$x."border='0', box".$x."ln=1,
							box".$x."align='L', box".$x."fill=0, box".$x."font='Arial'
						WHERE ThemeName='theme-03';";
				if(!$conn->query($sql))
				{
					$error = 'Error creating theme-03: ' . $conn->connect_error;
					exit();
				}
			}
			// set titles for sections in boxes 2, 5, 12, 16
			$sql = "UPDATE {$username}_templates
					SET box2text='Personal Information', box5text='Employment History', box12text='Education', box16text='Professional Qualifications',
					box2title=1, box5title=1, box12title=1, box16title=1,
					box2padding=2, box5padding=2, box12padding=2, box16padding=2
					WHERE ThemeName='theme-03';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-03: ' . $conn->connect_error;
				exit();
			}
			// set subtitles for sections in boxes 6, 8, 10, 17, 19
			$sql = "UPDATE {$username}_templates
					SET box6text='Work History', box8text='Academic Position', box10text='Research and Training', 
						box17text='Certifications', box19text='Academic Position', 
						box6subtitle=1, box8subtitle=1, box10subtitle=1, box17subtitle=1, box19subtitle=1
					WHERE ThemeName='theme-03';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-03: ' . $conn->connect_error;
				exit();
			}
			// set title/subtitle text size
			$sql = "UPDATE {$username}_templates
					SET box1size=17,
						box2size=14, box5size=14, box12size=14, box16size=14,
						box6size=12, box8size=12, box10size=12, box17size=12, box19size=12
					WHERE ThemeName='theme-03';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-03: ' . $conn->connect_error;
				exit();
			}
			// set box texts
			$sql = "UPDATE {$username}_templates
					SET box1text='name', box3text='phone', box4text='email',
						box7text='WorkHistory', box9text='AcaPosition', box11text='Reasearch', 
						box13text='University', box14text='Degree', box15text='Major',
						box18text='Certs', box20text='Accreds',
						box7multi=1, box9multi=1, box11multi=1, box18multi=1, box20multi=1
					WHERE ThemeName='theme-03';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-03: ' . $conn->connect_error;
				exit();
			}
			// customizations for theme-03
			$sql = "UPDATE {$username}_templates
					SET box1color='#009999', box21color='#009999',
						box1align='C',
						box1fill=1, box21fill=1,
						box1width=0, box21width=0,
						box2style='U', box5style='U', box12style='U', box16style='U',
						box6style='I', box8style='I', box10style='I', box17style='I', box19style='I'
					WHERE ThemeName='theme-03';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-03: ' . $conn->connect_error;
				print($error);
				exit();
			}
			//**************** End Default Template theme-03 ****************//

			//**************** Add Default Template theme-04 ****************//
			$sql = "INSERT INTO {$username}_templates (ThemeName) VALUES ('theme-04');";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-04: ' . $conn->connect_error;
				exit();
			}
			// theme-04 requires boxes 1-17
			for($x = 1; $x < 18; $x++)
			{
				$sql = "UPDATE {$username}_templates
						SET box".$x."=1, box".$x."width=20, box".$x."height=10, box".$x."border='0', box".$x."ln=1,
							box".$x."align='L', box".$x."fill=0, box".$x."font='Arial'
						WHERE ThemeName='theme-04';";
				if(!$conn->query($sql))
				{
					$error = 'Error creating theme-04: ' . $conn->connect_error;
					exit();
				}
			}
			// set titles for sections in boxes 4, 6, 8, 10, 14, 16
			$sql = "UPDATE {$username}_templates
					SET box4text='Work History', box8text='Research and Training', box14text='Academic Position', 
						box6text='Certifications', box10text='Education', box16text='Accreditations',
						box4title=1, box6title=1, box8title=1, box10title=1, box14title=1, box16title=1,
						box4padding=2, box6padding=2, box8padding=2, box10padding=2, box14padding=2, box16padding=2
					WHERE ThemeName='theme-04';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-04: ' . $conn->connect_error;
				exit();
			}
			// set title/subtitle text size
			$sql = "UPDATE {$username}_templates
					SET box4size=14, box6size=14, box8size=14, box10size=14, box14size=14, box16size=14
					WHERE ThemeName='theme-04';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-04: ' . $conn->connect_error;
				exit();
			}
			// set box texts
			$sql = "UPDATE {$username}_templates
					SET box1text='name', box2text='email', box3text='phone',
						box5text='WorkHistory', box7text='Certs', box9text='Reasearch',
						box11text='University', box12text='Degree', box13text='Major', 
						box15text='AcaPosition', box17text='Accreds',
						box5multi=1, box7multi=1, box9multi=1, box15multi=1, box17multi=1
					WHERE ThemeName='theme-04';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-04: ' . $conn->connect_error;
				exit();
			}
			// customizations for theme-04
			$sql = "UPDATE {$username}_templates
					SET box4color='#9A7045', box6color='#9A7045', box8color='#9A7045', box10color='#9A7045', box14color='#9A7045', box16color='#9A7045',
						box4fill=1, box6fill=1, box8fill=1, box10fill=1, box14fill=1, box16fill=1,
						box4width=0, box6width=0, box8width=0, box10width=0, box14width=0, box16width=0,
						box4font='Times', box6font='Times', box8font='Times', box10font='Times', box14font='Times', box16font='Times',
						box1size=17
					WHERE ThemeName='theme-04';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-04: ' . $conn->connect_error;
				print($error);
				exit();
			}
			//**************** End Default Template theme-04 ****************//

			//**************** Add Default Template theme-05 ****************//
			$sql = "INSERT INTO {$username}_templates (ThemeName) VALUES ('theme-05');";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-05: ' . $conn->connect_error;
				exit();
			}
			// theme-05 requires boxes 1-17
			for($x = 1; $x < 18; $x++)
			{
				$sql = "UPDATE {$username}_templates
						SET box".$x."=1, box".$x."width=20, box".$x."height=10, box".$x."border='0', box".$x."ln=1,
							box".$x."align='L', box".$x."fill=0, box".$x."font='Arial'
						WHERE ThemeName='theme-05';";
				if(!$conn->query($sql))
				{
					$error = 'Error creating theme-05: ' . $conn->connect_error;
					exit();
				}
			}
			// set titles for sections in boxes 4, 6, 8, 10, 14, 16
			$sql = "UPDATE {$username}_templates
					SET box4text='Work History', box8text='Research and Training', box14text='Academic Position', 
						box6text='Certifications', box10text='Education', box16text='Accreditations',
						box4title=1, box6title=1, box8title=1, box10title=1, box14title=1, box16title=1,
						box4padding=2, box6padding=2, box8padding=2, box10padding=2, box14padding=2, box16padding=2
					WHERE ThemeName='theme-05';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-05: ' . $conn->connect_error;
				exit();
			}
			// set title/subtitle text size
			$sql = "UPDATE {$username}_templates
					SET box4size=14, box6size=14, box8size=14, box10size=14, box14size=14, box16size=14
					WHERE ThemeName='theme-05';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-05: ' . $conn->connect_error;
				exit();
			}
			// set box texts
			$sql = "UPDATE {$username}_templates
					SET box1text='name', box2text='email', box3text='phone',
						box5text='WorkHistory', box7text='Certs', box9text='Reasearch',
						box11text='University', box12text='Degree', box13text='Major', 
						box15text='AcaPosition', box17text='Accreds',
						box5multi=1, box7multi=1, box9multi=1, box15multi=1, box17multi=1
					WHERE ThemeName='theme-05';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-05: ' . $conn->connect_error;
				exit();
			}
			// customizations for theme-05
			$sql = "UPDATE {$username}_templates
					SET box1color='#9A7045', box2color='#9A7045', box3color='#9A7045', box4color='#9A7045', box6color='#9A7045', box8color='#9A7045', 
						box10color='#9A7045', box14color='#9A7045', box16color='#9A7045',
						box1fill=1, box2fill=1, box3fill=1, box4fill=1, box6fill=1, box8fill=1, box10fill=1, box14fill=1, box16fill=1,
						box1width=0, box2width=0, box3width=0,
						box4width=0, box6width=0, box8width=0, box10width=0, box14width=0, box16width=0,
						box4font='Times', box6font='Times', box8font='Times', box10font='Times', box14font='Times', box16font='Times',
						box4align='C', box6align='C', box8align='C', box10align='C', box14align='C', box16align='C',
						box1height=10, box2height=5, box3height=5,
						box3padding=4,
						box1align='L', box2align='R', box3align='R',
						box1size=17
					WHERE ThemeName='theme-05';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-05: ' . $conn->connect_error;
				print($error);
				exit();
			}
			//**************** End Default Template theme-05 ****************//

			//**************** Add Default Template theme-06 ****************//
			$sql = "INSERT INTO {$username}_templates (ThemeName) VALUES ('theme-06');";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-06: ' . $conn->connect_error;
				exit();
			}
			// theme-06 requires boxes 1-16
			for($x = 1; $x < 17; $x++)
			{
				$sql = "UPDATE {$username}_templates
						SET box".$x."=1, box".$x."width=20, box".$x."height=10, box".$x."border='0', box".$x."ln=1,
							box".$x."align='L', box".$x."fill=0, box".$x."font='Arial'
						WHERE ThemeName='theme-06';";
				if(!$conn->query($sql))
				{
					$error = 'Error creating theme-06: ' . $conn->connect_error;
					exit();
				}
			}
			// set titles for sections in boxes 4, 6, 12
			$sql = "UPDATE {$username}_templates
					SET box4text='Work History', box6text='Education', box12text='Professional Qualifications',
						box4title=1, box6title=1, box12title=1,
						box4padding=2, box6padding=2, box8padding=2, box10padding=2, box14padding=2, box16padding=2
					WHERE ThemeName='theme-06';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-06: ' . $conn->connect_error;
				exit();
			}
			// set subtitles for sections in boxes 10, 13, 15
			$sql = "UPDATE {$username}_templates
					SET box10text='Academic Position', box13text='Certifications', box15text='Accreditations',
						box10subtitle=1, box13subtitle=1, box15subtitle=1
					WHERE ThemeName='theme-06';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-06: ' . $conn->connect_error;
				exit();
			}
			// set title/subtitle text size
			$sql = "UPDATE {$username}_templates
					SET box4size=14, box6size=14, box12size=14, 
					box10size=12, box13size=12, box15size=12
					WHERE ThemeName='theme-06';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-06: ' . $conn->connect_error;
				exit();
			}
			// set box texts
			$sql = "UPDATE {$username}_templates
					SET box1text='name', box2text='phone', box3text='email',
						box5text='WorkHistory', box7text='University', box8text='Degree',
						box9text='Major', box11text='AcaPosition', box14text='Certs', box16text='Accreds',
						box5multi=1, box11multi=1, box9multi=1, box14multi=1, box16multi=1
					WHERE ThemeName='theme-06';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-06: ' . $conn->connect_error;
				exit();
			}
			// customizations for theme-06
			$sql = "UPDATE {$username}_templates
					SET box1fontColor='#39AAF1', box4fontColor='#39AAF1', box6fontColor='#39AAF1', box12fontColor='#39AAF1',
						box1size=17,
						box1align='C', box2align='C', box3align='C',
						box1width=0, box2width=0, box3width=0, box4width=0, box6width=0, box12width=0,
						box4border='B', box6border='B', box12border='B',
						box10fontColor='#39AAF1', box13fontColor='#39AAF1', box15fontColor='#39AAF1'
					WHERE ThemeName='theme-06';";
			if(!$conn->query($sql))
			{
				$error = 'Error creating theme-06: ' . $conn->connect_error;
				print($error);
				exit();
			}
			//**************** End Default Template theme-06 ****************//

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
