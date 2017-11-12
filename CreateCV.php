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
		$pdf->SetFont('Times', '', $theme->header->fontsize);
		$pdf->Cell(40, 10, 'Hello World');
		$pdf->Cell(60,10,'Powered by FPDF.',0,1,'C');
		$pdf->Output();
	}
?>