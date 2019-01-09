<?php
	include '../model/function.php';

	if(!isset($_POST['compare']))
		die('geen files');

	$input_1 = $_FILES['txt1']['tmp_name'];
	$input_2 = $_FILES['txt2']['tmp_name'];
	
	if(compare($input_1, $input_2)){
		echo"<script> alert('voltooid. ga nu naar het bestand file.txt in de csv map.')</script>";
		//header('location: ../view/csv_vergelijker.php');
	}
	else{
		echo"<script> alert('voltooid. ga nu naar het bestand file.txt in de csv map.')</script>";
		//header('location: ../view/csv_vergelijker.php');
	}
?>
