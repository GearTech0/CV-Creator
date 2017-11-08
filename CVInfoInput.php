<!DOCTYPE html>
<html lang="en-US">
<html>
<head>
	<title>CV Creation Software</title>
	<link rel="stylesheet" href="inputPage.css">
</head>
	<h1><a href = "Index.html">CV Creation Software</a></h1>
	<h2>CV Information Input</h2>
	<h3>Personal Information</h3>
	<form>
		Name:<br>
		<input type = "text" name = "First and Last"><br>
		Phone Number:<br>
		<input type = "tel" name = "Phone Number"><br>
		Email:<br>
		<input type = "email" name = "Email"><br>
	</form>
	<h3>Employment History</h3>
	<form id = "EmploymentHistoryForm">
		Work History:<br>
		<textarea form = "EmploymentHistoryForm" name = "WorkHistory" rows = "10" cols = "50" placeholder = "Enter work history here..">	
		</textarea><br>
		Academic Position:<br>
		<textarea form = "EmploymentHistoryForm" name = "AcaPosition" rows = "10" cols = "50" placeholder = "Enter academic position here..">	
		</textarea><br>
		Research and Training:<br>
		<textarea form = "EmploymentHistoryForm" name = "Reasearch" rows = "10" cols = "50" placeholder = "Enter any research or training here..">	
		</textarea><br>
	</form>
	<h3>Education</h3>
	<form>
		University Attended:<br>
		<input type = "text" name = "University"><br>
		Degree:<br>
		<input type = "text" name = "Degree"><br>
		Major:<br>
		<input type = "text" name = "Major"><br>
	</form>
	<h3>Professional Qualifications</h3>
	<form id = "QualificationsForm">
		Certifications:<br>
		<textarea form = "QualificationsForm" name = "Certs" rows = "10" cols = "50" placeholder = "Enter certifications here..">	
		</textarea><br>
		Accreditations:<br>
		<textarea form = "QualificationsForm" name = "Accreds" rows = "10" cols = "50" placeholder = "Enter accreditations here..">	
		</textarea><br>
	</form>
</html>