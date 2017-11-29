<!DOCTYPE html>
<html lang="en-US">
<html>
<head>
	<title>CV Creation Software</title>
	<link rel="stylesheet" href="css/login.css">
</head>
<body>
	<?
		require "docxtotext.php";

		$docObj = new Doc2Txt("test.docx");
		echo "hello";
		echo "<div class=\"test\">".$docObj->convertToText()."</div>";
	?>
</body>
</html>
