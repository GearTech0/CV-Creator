<!DOCTYPE html>
<html lang="en-US">
<html>
<head>
	<title>CV Creation Software</title>
	<link rel="stylesheet" href="css/login.css">
</head>
<body>
	<h1><a href = "Index.PHP">CV Creation Software</a></h1>
	<h1>Login</h1>
	<form action = "CheckUser.PHP" method = "post">
		Username:<br>
		<input type = "text" name = "username" required><br>
		Password:<br>
		<input type = "password" name = "pass" required>
		<input type = "submit" name = "submit" value = "Submit">
		<input type = "reset" value = "Clear">
	</form>
	<p>Don't have an account? <a href = "CreateAccount.PHP">Create one</a></p>
</body>
</html>