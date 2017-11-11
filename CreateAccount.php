<!DOCTYPE html>
<html lang="en-US">
<html>
<head>
	<title>CV Creation Software</title>
	<link rel="stylesheet" href="css/login.css">
</head>
<body>
	<h1><a href = "Index.PHP">CV Creation Software</a></h1>
	<h1>Create Account</h1>
	<form action = "SendUser.PHP" method = "post">
		Username:<br>
		<input type = "text" name = "username"><br>
		Password:<br>
		<input type = "password" name = "password">
		<input type = "submit" value = "Submit" name = "submit">
		<input type = "reset" value = "Clear">
	</form>
	<p>Already have an account? <a href = "Login.PHP">Login here</a></p>
</body>
</html>