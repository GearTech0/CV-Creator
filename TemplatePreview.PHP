<!DOCTYPE html>
<html lang="en-US">
<?php
    session_set_cookie_params(0);
    session_start();
?>
<html>
<head>
	<title>CV Creation Software - Templates</title>
	<link rel="stylesheet" href="css/TemplatePreview.css">
</head>
<body>
	<h1><a href = "Index.PHP">CV Creation Software</a></h1>
    <h2>Template Preview</h2>
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
    </table><br>
    <?php
        /**
        * This code gets all saved templates from the users uploads folder (if any)
        * No parameters
        * No return values
        **/
        // this code is redundant - will be changed
        /*
        if(isset($_SESSION['login_user']))
        {
            echo "<h3>" . $_SESSION['login_user'] . " uploaded custom templates:</h3>";
            $target_dir = "uploads/" . $_SESSION['login_user'];
            if(!file_exists($target_dir))
            {
                mkdir($target_dir, 0777, true);
            }
            echo "<ul>";
            foreach(glob($target_dir.'/*.docx') as $file)
            {
                echo "<li>" . basename($file) . "</li>";
            }
            echo "</ul>";
        }
        */
    ?>
    <h3>Have your own template? <a href="UploadTemplate.PHP">Upload it here</a></h3>
</body>
</html>