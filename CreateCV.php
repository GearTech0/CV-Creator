<?php

	require "includes/fpdf181/fpdf.php";	// Grab PDF generation library

	/**
	* CreateCV
	* Writes $report information .PDF based on $theme specifications
	*
	*
	* $theme array specifications on how the PDF will look 
	*	array(
			header => array(
				x => int,
				y => int,
				color => string, //hexcode
				backgroundcolor => string, //hexcode
				fontsize => int
			),
			body => array(
				x => int,
				y => int,
				color => string, //hexcode
				backgroundcolor => string, //hexcode
				fontsize => int
			),
			footer => array(
				x => int,
				y => int,
				color => string, //hexcode
				backgroundcolor => string, //hexcode
				fontsize => int
			)
		)
	* $report array information to write to PDF
		array(
			name => string,
			number => string,
			email => string
		)
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
	* GetTheme
	* Retrieve theme '$themeName' from database
	*
	*
	* $themeName string name of the theme
	* return array theme array 
	*/
	function GetTheme($themeName)
	{
		// Query DB for theme information

		// Set theme information into theme array in respective positions
		$theme = [
			'header' => [
				'x' => 0,
				'y' => 0,
				'color' => '#FF0000',
				'backgroundcolor' => '#FF0000',
				'fontsize' => 10,
				'font' => 'Arial'
			],
			'body' => [
			
			],
			'footer' => [
			
			]
		];

		// Return the theme array
		return $theme;
	}

	if(isset($_POST['submit']))
	{

		// Get the theme to use for the CV
		$theme = GetTheme('theme-01');

		$report = [
			'name' => htmlspecialchars($_POST['name']),
			'phone' => htmlspecialchars($_POST['phone']),
			'email' => htmlspecialchars($_POST['email'])
		];

		CreateCV($theme, $report);
	}
?>