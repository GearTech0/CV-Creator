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
  *   title => array(
  *     style => char
  *   ),
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
    $move = $theme['header']['x'];
    $textAreaW = 0;
    $textW = 10;
    $height = 5;

    /* Underlining
    $pdf->SetFont($theme['header']['font'], 'U', $theme['header']['fontsize'],'U');
    $pdf->Cell(10,$height,'Personal Information',0,1,'C');
    $pdf->SetFont($theme['header']['font'], '', $theme['header']['fontsize']);
    */

    /* Coloring
    $pdf->SetFillColor(0,153,255);
    $pdf->Cell(0,10,$report['name'],0,1,'C',1);
    $pdf->Ln(12);
    */

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont($theme['header']['font'], $theme['title']['style'], $theme['header']['fontsize']);
    $pdf->Cell($move);

    /*
    if($theme['header']['backgroundcolor'] != '#FFFFFF')
    {
      $pdf->
    }
    */

    $pdf->Cell(10,$height,'Personal Information',0,1,'C');
    $pdf->SetFont($theme['header']['font'], '', $theme['header']['fontsize']);
    $pdf->Ln(4);
    $pdf->Cell($textW,$height,$report['name'],0,1,'L');
    $pdf->Cell($textW,$height,$report['phone'],0,1,'L');
    $pdf->Cell($textW,$height,$report['email'],0,1,'L');
    $pdf->Ln(6);

    $pdf->Cell($move);
    $pdf->SetFont($theme['header']['font'], $theme['title']['style'], $theme['header']['fontsize']);
    $pdf->Cell(10,$height,'Employment History',0,1,'C');
    $pdf->SetFont($theme['header']['font'], '', $theme['header']['fontsize']);
    $pdf->Ln(4);
    $pdf->MultiCell($textAreaW,$height,$report['WorkHistory'],0,'L');
    $pdf->Ln(4);
    $pdf->MultiCell($textAreaW,$height,$report['AcaPosition'],0,'L');
    $pdf->Ln(4);
    $pdf->MultiCell($textAreaW,$height,$report['Reasearch'],0,'L');
    $pdf->Ln(6);

    $pdf->Cell(7);
    $pdf->SetFont($theme['header']['font'], $theme['title']['style'], $theme['header']['fontsize']);
    $pdf->Cell(10,$height,'Education',0,1,'C');
    $pdf->SetFont($theme['header']['font'], '', $theme['header']['fontsize']);
    $pdf->Ln(4);
    $pdf->Cell($textW,$height,$report['University'],0,1,'L');
    $pdf->Cell($textW,$height,$report['Degree'],0,1,'L');
    $pdf->Cell($textW,$height,$report['Major'],0,1,'L');
    $pdf->Ln(6);

    $pdf->Cell(27);
    $pdf->SetFont($theme['header']['font'], $theme['title']['style'], $theme['header']['fontsize']);
    $pdf->Cell(10,$height,'Professional Qualifications',0,1,'C');
    $pdf->SetFont($theme['header']['font'], '', $theme['header']['fontsize']);
    $pdf->Ln(4);
    $pdf->MultiCell($textAreaW,$height,$report['Certs'],0,'L');
    $pdf->Ln(4);
    $pdf->MultiCell($textAreaW,$height,$report['Accreds'],0,'L');

    $pdf->Output();
  }

  /**
  * SaveCVInformation
  * Save current cv information to database
  *
  * $report array of input values from user
  * $username current logged in user
  * $cvname current active CV name
  * void return
  */
  function SaveCVInformation($report, $username, $cvname)
  {
    require "Config.PHP";
    $name = $report['name'];
    $phone = $report['phone'];
    $email = $report['email'];
    $work = $report['WorkHistory'];
    $acad = $report['AcaPosition'];
    $research = $report['Reasearch'];
    $uni = $report['University'];
    $degree = $report['Degree'];
    $major = $report['Major'];
    $certs = $report['Certs'];
    $accreds = $report['Accreds'];
    // Update database entry with inputted information
    $sql = "UPDATE `{$username}_previous_cv` 
            SET Name='$name', Phone='$phone', Email='$email', WorkHistory='$work', Academic='$acad', Research='$research',
                University='$uni', Degree='$degree', Major='$major', Certs='$certs', Accreds='$accreds'
            WHERE CVName='$cvname'";
    $result = $conn->query($sql);
    if($result)
    {
      $error = 'Saved successfully';
    }else
    {
      $error = 'Save failed';
    }
    $conn->close();
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
          'title' => [
            'style' => $row['title_style']
          ],
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

    SaveCVInformation($report, $_SESSION['login_user'], $_SESSION['currentCV']);
  }else if(isset($_POST['save']))
  {
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
    ];
    SaveCVInformation($report, $_SESSION['login_user'], $_SESSION['currentCV']);
    header("Location: CVInfoInput.php");
  }
?>
