<?php
	include "DbConfig.php";
	$sqlkonexioa = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

	if($sqlkonexioa->connect_errno) {
		die( "Huts egin du konexioak MySQL-ra: (".$sqlkonexioa-> connect_errno . ") " .$sqlkonexioa-> connect_error );
	}
	if($_POST['action'] == "liked"){
		if($_POST['plus'] == "true")
			$sql = "UPDATE questions SET likes = likes + 1 WHERE galderaID = '".$_POST['id']."'";
		else
			$sql = "UPDATE questions SET likes = likes - 1 WHERE galderaID = ".$_POST['id']."";
	}else{
		if($_POST['plus'] == "true")
			$sql = "UPDATE questions SET dislikes = dislikes + 1 WHERE galderaID = ".$_POST['id']."";
		else
			$sql = "UPDATE questions SET dislikes = dislikes + 1 WHERE galderaID = ".$_POST['id']."";
	}
	if (!$sqlkonexioa->query($sql)) {
		echo "<p>Errore bat gertatu da. " .$sqlkonexioa->error. "</p>";
	}
?>