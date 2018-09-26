<?php

	include("../phplib.php");

	$img = "";

	!empty($_GET['img']) ? $img = $_GET['img'] : header("Location: ../../index.php");

	$sql = "SELECT Percorso FROM img_news WHERE ID = ".$img;
	$result = $conn->query($sql);
	$temp = $result->fetch_array();
	$percorso = $temp['Percorso'];

	unlink("../../../img/news/hd".$percorso);

	unlink("../../../img/news/thumbnails".$percorso);


	$sql = "DELETE FROM img_news WHERE ID = ".$img;

	$conn->query($sql) or die ("Impossibile rimuover questa immagine, me spiasa");

	header("Location: ../../managenewsimages.php");

?>