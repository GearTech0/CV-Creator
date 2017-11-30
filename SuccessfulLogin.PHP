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
	<title>CV Creation Software</title>
	<link rel="stylesheet" href="css/SuccessfulLog.css">
</head>
<body>
	<h1><a href = "Index.PHP">CV Creation Software</a></h1>
	<h2>Welcome</h2>
	<?php if(isset($_SESSION['admin']) && $_SESSION['admin']): ?>
        <a href="AdminControls.PHP"><h4>Admin Tools</h4></a>
    <?php endif; ?>
	<h3><a href = "TemplatePreview.PHP">View Templates</a></h3>
	<h3><a href = "UploadTemplate.PHP">Upload Templates</a></h3>
	<h3><a href = "NameCV.PHP">Create CV</a></h3>
	<h3><a href = "EditSaved.PHP">Edit Existing CV</a></h3>
	<h3><a href = "ViewSaved.PHP">View Saved CV</a></h3>
	<p><a href = "Logout.PHP">Logout</a></p>
</body>
</html>