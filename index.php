<?php


$filename = 'initialFile.csv';

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

		if ($stringLen > 14) {
			$asterix = "**...**";
		}else{
			for ($i=0; $i <= $asterixLen; $i++) { 
				array_push($element, '*');
			}

			$asterix = implode('', $element);
		}

		$replace = substr_replace($row[1], $asterix, 3, -5);
		array_push($editedValues, $replace);
	}

	$updatedFile = fopen('updated.csv', 'w');

	for ($i=0; $i <= $rowsNumber; $i++) { 
			$rows[$i][1] = $editedValues[$i];
            fputcsv($updatedFile, $rows[$i]);
	}

	fclose($h);
}