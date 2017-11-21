<!DOCTYPE html>
<html lang="en-US">
<?php
    session_set_cookie_params(0);
    session_start();
?>
<html>
<head>
	<title>CV Creation Software</title>
	<link rel="stylesheet" href="css/homestyles.css">
</head>
<body>
	<h1>CV Creation Software</h1>
    <?php if(isset($_SESSION['admin']) && $_SESSION['admin']): ?>
        <a href="AdminControls.PHP"><h4>Admin Tools</h4></a>
    <?php endif; ?>
    <?php if(isset($_SESSION['logged_in'])): ?>
        <?php echo "<p>Logged in as " . $_SESSION['login_user'] . "</p>"; ?>
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
        <?php if(isset($_SESSION['logged_in'])): ?>
            <a href="ViewSaved.PHP"><li>View Saved CV</li></a>
            <a href="EditSaved.PHP"><li>Edit Saved CV</li></a>
            <a href="UploadTemplate.php"><li>Upload Custom Template</li></a>
        <?php endif; ?>
    </ul>
    <?php if(isset($_SESSION['logged_in'])): ?>
        <a href="Logout.PHP"><h4>Logout</h4></a>
    <?php endif; ?>
</body>
</html>