<?php

/**
 * This is a tool that's going to take a CSV file and will manipulate a certain column on
 * every row and will censor the contents with asterix
 *
 * There is a minimum value also included so if you would like to have some columns not
 * censored because the censorship won't make sense. You can set a minimum length.
 *
 * If you don't want to do that, you can simply set the $minLength to 0
 */

/**
 * Required values
 */

// Name of the initial file
$filename = 'initialFile.csv';
// Name of the file that will be exported
$updatedFileRaw = 'updated.csv';
// Minimum length of a column contains
$minLength = 14;
// Name of the default value for less than minimum entries
$defaultValue = '**...**';

$the_big_array = []; 

if (($h = fopen("{$filename}", "r")) !== FALSE) 
{
	while (($data = fgetcsv($h, 1000, ",")) !== FALSE) 
	{
		$the_big_array[] = $data;		
	}

	$rows = $the_big_array;
	$editedValues = array();
	$rowsNumber = count($rows);

	foreach($rows as $row){
		$stringLen = strlen($row[1]);
		$asterixLen = $stringLen - 8;
		$element = array();

		if ($stringLen > $minLength) {
			$asterix = $defaultValue;
		}else{
			for ($i=0; $i <= $asterixLen; $i++) { 
				array_push($element, '*');
			}

			$asterix = implode('', $element);
		}

		$replace = substr_replace($row[1], $asterix, 3, -5);
		array_push($editedValues, $replace);
	}

	$updatedFile = fopen($updatedFileRaw, 'w');

	for ($i=0; $i <= $rowsNumber; $i++) { 
			$rows[$i][1] = $editedValues[$i];
            fputcsv($updatedFile, $rows[$i]);
	}

	fclose($h);
}