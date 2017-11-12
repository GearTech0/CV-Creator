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
				backgroundcolor => string //hexcode
			),
			body => array(
				x => int,
				y => int,
				color => string, //hexcode
				backgroundcolor => string //hexcode
			),
			footter => array(
				x => int,
				y => int,
				color => string, //hexcode
				backgroundcolor => string //hexcode
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
		
	}
?>