<!DOCTYPE html>
<html lang="en-US">
<html>
<head>
	<title>CV Creation Software</title>
	<link rel="stylesheet" href="css/homestyles.css">
</head>
<body>
	<h1>CV Creation Software</h1>
    <?php if(isset($_SESSION['logged_in'])): ?>
        <a href="Logout.PHP"><h4>Logout</h4></a>
    <?php else: ?>
        <a href="Login.PHP"><h3>Login</h3></a>
        <a href="CreateAccount.PHP"><h3>Sign Up</h3></a>
    <?php endif; ?>
    <ul>
        <a href="TemplatePreview.PHP">
            <li>View Sample Templates</li>
        </a>
        <a href="CVInfoInput.PHP">
            <li>Create a CV</li>
        </a>
    </ul>
</body>
</html>