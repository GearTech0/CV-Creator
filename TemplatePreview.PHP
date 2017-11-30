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
                <img src="images/theme-01.jpg" alt="template1">
                <figcaption>Template 1</figcaption>
            </td>
            <td>
                <img src="images/theme-02.jpg" alt="template2">
                <figcaption>Template 2</figcaption>
            </td>
            <td>
                <img src="images/theme-03.jpg" alt="template3">
                <figcaption>Template 3</figcaption>
            </td>
        </tr>
        <tr>
            <td>
                <img src="images/theme-04.jpg" alt="template4">
                <figcaption>Template 4</figcaption>
            </td>
            <td>
                <img src="images/theme-05.jpg" alt="template5">
                <figcaption>Template 5</figcaption>
            </td>
            <td>
                <img src="images/theme-06.jpg" alt="template6">
                <figcaption>Template 6</figcaption>
            </td>
        </tr>
        <tr>
            <td>
                <img src="images/theme-07.jpg" alt="template7">
                <figcaption>Template 7</figcaption>
            </td>
            <td>
                <img src="images/theme-08.jpg" alt="template8">
                <figcaption>Template 8</figcaption>
            </td>
            <td>
                <img src="images/theme-09.jpg" alt="template9">
                <figcaption>Template 9</figcaption>
            </td>
        </tr>
        <tr>
            <td>
                <img src="images/theme-10.jpg" alt="template10">
                <figcaption>Template 10</figcaption>
            </td>
        </tr>
    </table><br>
    <?php
        /**
        * This code gets all saved templates from the users uploads folder (if any)
        * No parameters
        * No return values
        **/
        if(isset($_SESSION['login_user']))
        {
          require("Config.php");
          $sql = "SELECT `ThemeName` FROM " . $_SESSION['login_user'] . "_templates";
          $result = $conn->query($sql);

          if($result->num_rows > 0)
          {
            echo '<h3>Your uploaded templates:</h3>';
            $themes = array("theme-01", "theme-02", "theme-03", "theme-04",
                            "theme-05", "theme-06", "theme-07", "theme-08",
                            "theme-09", "theme-10");

            while($row = $result->fetch_assoc()) {
              if(!in_array($row['ThemeName'], $themes))
              {
                echo '<p>' . $row['ThemeName'] . '</p><br>';
              }
            }
          }
        }
    ?>
    <h3>Have your own template? <a href="UploadTemplate.PHP">Upload it here</a></h3>
</body>
</html>
