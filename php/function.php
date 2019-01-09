<?php

function row_compare($a, $b){
	if ($a === $b) {
        return 0;
    }

    return (implode("",$a) < implode("",$b) ) ? -1 : 1;
}
function compare($input_1, $input_2){
	 
	try{
		//ophalen van de files als objecten.
		$file1 = new SplFileObject($input_1);

		//de csv uit lezen en de lege plekken overslaan.
		$file1->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);


		$file2 = new SplFileObject($input_2);
		$file2->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
	}
	catch(Exception $e){
		echo $e;
	}

	//bij grote csv files aan zetten.
	ini_set("memory_limit",-1);

	//objecten omzetten naar csv's en alleen kijken naar een bepaalde row.
	foreach ($file1 as $row) {
    	$csv_1[] = $row;
	}

	foreach ($file2 as $row) {
    	$csv_2[] = $row;
	}


	// de csv files met elkaar vergelijken. van links naar rechts en van rechts naar links.
	$unique_to_csv1 = array_udiff($csv_1, $csv_2, 'row_compare');
	$unique_to_csv2 = array_udiff($csv_2, $csv_1, 'row_compare');

	//de rows die niet in beide csv's voor komen bij elkaar voegen.
	$all_unique_rows = array_merge($unique_to_csv1,$unique_to_csv2);

	//zet $i op 0 zodat de eerste index van de array 0 is. inplaats van 1.
	$i = "-1";

	// de unieke rows onder elkaar zetten.
	foreach($all_unique_rows as $unique_row) {
		$i++;
    
    	foreach($unique_row as $element) {
    		echo $element. " "; 
    	}
    	echo '<br />';
    	echo '<br />'; 
    	//hier maak je een list aan en schijf je alle "id" en "naam" weg naar de list met $i als index nummer.
    	list($sku[$i], $ean[$i]) = $unique_row;
	}

	$file = fopen('../csv/file.txt', 'w');

	$s = "-1";

	foreach($sku as $index){
    	$s++;
    	//schrijf eerst het id weg en zet er een comma als seperator achter.
    	fwrite($file, $index. ",");

    	//schrijf de naam van het product meteen na de comma en start daarna op een nieuwe lijn.
    	fwrite($file, $ean[$s].PHP_EOL);
	}

	// $i +="1" zorgt ervoor dat de aantal verschillen op het juiste aantal verschillen komt, omdat hij begint te tellen bij 0.
	$i +="1";

	echo"aantal verschillen",'&nbsp',$i;
	echo'<br/>';

	fclose($file);

	echo'<form action="../html/csv_vergelijker.php">';
	echo'<input type="submit" value="terug" style="position:inherit; right:1019px; top:146px;">';
	echo'</form>';
}	
?>