<?php

	include("../phplib.php");

	$img = "";

	!empty($_GET['img']) ? $img = $_GET['img'] : header("Location: ../../index.php");

	$sql = "SELECT Percorso FROM img_press WHERE ID = ".$img;
	$result = $conn->query($sql);
	$temp = $result->fetch_array();
	$percorso = $temp['Percorso'];

	unlink("../../../img/press/hd".$percorso);

	unlink("../../../img/press/thumbnails".$percorso);


	$sql = "DELETE FROM img_press WHERE ID = ".$img;

	$conn->query($sql) or die ("Impossibile rimuover questa immagine, me spiasa");

	header("Location: ../../managepressimages.php");

?>