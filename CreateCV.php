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

    /* Each cell needs:
    * width (if 0, extend to right margin)
    * height
    * text
    * border (0 no border, 1 border)(L left, T top, R right, B bottom)
    * ln (0 right, 1 next line, 2 below)
    * align ('' left align, L left align, C center align, R right align)
    * fill (true or false)
    * color (hex value, 7 character varchar)
    * font
    * style ('U' underline, 'I' italics, 'B' bold)
    * size
    */
    $pdf = new FPDF();
    $pdf->AddPage();
    for($x = 1; $x < 31; $x++)
    {
      if($theme['box'.$x]['use'] == 1)
      {
        // set cell font
        $pdf->SetFont($theme['box'.$x]['font'], $theme['box'.$x]['style'], $theme['box'.$x]['size']);
        // set cell color
        list($r, $g, $b) = sscanf($theme['box'.$x]['color'], "#%02x%02x%02x");
        $pdf->SetFillColor($r,$g,$b);
        // set font/border color
        list($r, $g, $b) = sscanf($theme['box'.$x]['fontColor'], "#%02x%02x%02x");
        $pdf->SetTextColor($r,$g,$b);
        $pdf->SetDrawColor($r,$g,$b);
        // create cell
        if($theme['box'.$x]['title'] || $theme['box'.$x]['subtitle'])
        {
          $pdf->Cell($theme['box'.$x]['width'],$theme['box'.$x]['height'],$theme['box'.$x]['text'],$theme['box'.$x]['border'],
                  $theme['box'.$x]['ln'],$theme['box'.$x]['align'], $theme['box'.$x]['fill']);
        }else
        {
          if($theme['box'.$x]['multi'])
          {
            $pdf->MultiCell(0,$theme['box'.$x]['height'],$report[$theme['box'.$x]['text']],$theme['box'.$x]['border'],
                  $theme['box'.$x]['align'], $theme['box'.$x]['fill']);
          }else
          {
            $pdf->Cell($theme['box'.$x]['width'],$theme['box'.$x]['height'],$report[$theme['box'.$x]['text']],$theme['box'.$x]['border'],
                  $theme['box'.$x]['ln'],$theme['box'.$x]['align'], $theme['box'.$x]['fill']);
          }
        }
        $pdf->Ln($theme['box'.$x]['padding']);
        if($theme['box'.$x]['ln'] == 0 && $theme['box'.$x]['move'] != 0)
        {
          $pdf->Cell($theme['box'.$x]['move']);
        }
      }
    }

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

    /* Each cell needs:
    * width (if 0, extend to right margin)
    * height
    * text
    * border (0 no border, 1 border)(L left, T top, R right, B bottom)
    * ln (0 right, 1 next line, 2 below)
    * align ('' left align, L left align, C center align, R right align)
    * fill (true or false)
    * color (hex value, 7 character varchar)
    * font
    * style ('U' underline, 'I' italics, 'B' bold)
    * size
    */
    if($result->num_rows > 0)
    {
      while($row = $result->fetch_assoc()) {
        // Set theme information into theme array in respective positions
        $theme = [];
        for($x = 1; $x < 31; $x++)
        {
            $temp = [
              'use' => $row['box'.$x],
              'width' => $row['box'.$x.'width'],
              'height' => $row['box'.$x.'height'],
              'text' => $row['box'.$x.'text'],
              'border' => $row['box'.$x.'border'],
              //'borderPlace' => $row['box'.$x.'borderPlace'],
              'ln' => $row['box'.$x.'ln'],
              'align' => $row['box'.$x.'align'],
              'fill' => $row['box'.$x.'align'],
              'color' => $row['box'.$x.'color'],
              'font' => $row['box'.$x.'font'],
              'style' => $row['box'.$x.'style'],
              'size' => $row['box'.$x.'size'],
              'title' => $row['box'.$x.'title'],
              'subtitle' => $row['box'.$x.'subtitle'],
              'multi' => $row['box'.$x.'multi'],
              'move' => $row['box'.$x.'move'],
              'fontColor' => $row['box'.$x.'fontColor'],
              'padding' => $row['box'.$x.'padding']
            ];
            $theme['box'.$x] = $temp;
        }
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