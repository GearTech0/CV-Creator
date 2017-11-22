<?php
  session_start();
  require "includes/fpdf181/fpdf.php";	// Grab PDF generation library
  $error = "";
  /**
  * CreateCV
  * Writes $report information .PDF based on $theme specifications
  *
  *
  * $theme array specifications on how the PDF will look
  *	array(
  *		header => array(
  *			x => int,
  *			y => int,
  *			color => string, //hexcode
  *			backgroundcolor => string, //hexcode
  *			fontsize => int
  *		),
  *		body => array(
  *			x => int,
  *			y => int,
  *			color => string, //hexcode
  *			backgroundcolor => string, //hexcode
  *			fontsize => int
  *		),
  *		footer => array(
  *			x => int,
  *			y => int,
  *			color => string, //hexcode
  *			backgroundcolor => string, //hexcode
  *			fontsize => int
  *		)
  *	)
  * $report array information to write to PDF
  *	array(
  *		name => string,
  *		number => string,
  *		email => string
  *	)
  */
  function CreateCV($theme, $report)
  {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont($theme['header']['font'], '', $theme['header']['fontsize']);

    // Create Header if CV
    $pdf->Cell(80);
    $pdf->Cell(10,5,$report['name'],0,1,'C');
    $pdf->Cell(80);
    $pdf->Cell(10,5,$report['phone'],0,1,'C');
    $pdf->Cell(80);
    $pdf->Cell(10,5,$report['email'],0,1,'C');


    $pdf->Output();
  }

  /**
  *
  *
  *
  *
  *
  */
  function SaveCVInformation($report)
  {

  }

  /**
  * GetTheme
  * Retrieve theme '$themeName' from database
  *
  *
  * $themeName string name of the theme
  * return array theme array
  */
  function GetTheme($themeName, $username)
  {
    require "Config.PHP";
    // Query DB for theme information
    $sql = "SELECT * FROM `{$username}_templates` WHERE `ThemeName`='$themeName'";
    $result = $conn->query($sql);

    if($result->num_rows > 0)
    {
      while($row = $result->fetch_assoc()) {
        // Set theme information into theme array in respective positions
        $theme = [
          'header' => [
            'x' => $row['header_x'],
            'y' => $row['header_y'],
            'color' => $row['header_color'],
            'backgroundcolor' => $row['header_bgcolor'],
            'fontsize' => $row['header_fontsize'],
            'font' => $row['header_font']
          ],
          'body' => [
            'x' => $row['body_x'],
            'y' => $row['body_y'],
            'color' => $row['body_color'],
            'backgroundcolor' => $row['body_bgcolor'],
            'fontsize' => $row['body_fontsize'],
            'font' => $row['body_font']
          ],
          'footer' => [
            'x' => $row['footer_x'],
            'y' => $row['footer_y'],
            'color' => $row['footer_color'],
            'backgroundcolor' => $row['footer_bgcolor'],
            'fontsize' => $row['footer_fontsize'],
            'font' => $row['footer_font']
          ]
        ];
      }
    }
    else
    {
        $error = "There are no templates available to this user.";
    }

    $conn->close();
    // Return the theme array
    return $theme;
  }

  if(!isset($_SESSION['login_user']))
  {
    // Not logged in
    echo "You are not logged in. Please <a href=\"Login.php\">Log In</a> to do this action.";
    exit();
  }
  else if(isset($_POST['submit']) && isset($_POST['name']) && isset($_POST['phone']))
  {

    // Get the theme to use for the CV
    $theme = GetTheme($_POST['template'], $_SESSION['login_user']);

    $report = [
      'name' => htmlspecialchars($_POST['name']),
      'phone' => htmlspecialchars($_POST['phone']),
      'email' => htmlspecialchars($_POST['email']),

      'WorkHistory' => htmlspecialchars($_POST['WorkHistory']),
      'AcaPosition' => htmlspecialchars($_POST['AcaPosition']),
      'Reasearch' => htmlspecialchars($_POST['Reasearch']),

      'University' => htmlspecialchars($_POST['University']),
      'Degree' => htmlspecialchars($_POST['Degree']),
      'Major' => htmlspecialchars($_POST['Major']),

      'Certs' => htmlspecialchars($_POST['Certs']),
      'Accreds' => htmlspecialchars($_POST['Accreds']),

      'template' => htmlspecialchars($_POST['template']),
      'pdfChoose' => htmlspecialchars($_POST['pdfChoose'])
    ];

    //if($_POST['pdfchoose'])
      CreateCV($theme, $report);

    SaveCVInformation($report);
  }
?>
