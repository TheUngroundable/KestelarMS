<?php

	include("../phplib.php");


	$id = $img = "";

	!empty($_GET['id']) ? $id = $_GET['id'] : header("Location: ../../index.php");

	if($_GET['img'] == 0){

		header("Location: ../../editnews.php?id=".$id);

	}

	$img = $_GET['img'];

	//Get previous Progressivo
	$sql = "SELECT Progressivo FROM img_news WHERE FK_News = ".$id." AND progressivo < ".$img." ORDER BY Progressivo DESC LIMIT 1";

	$result = $conn->query($sql);

	$row = $result->fetch_assoc();

	$previousProgressivo = $row['Progressivo'];

	
	//move previousProgressivo to dummyProgressivo
	$sql = "UPDATE img_news SET progressivo = 127 WHERE progressivo = ".$previousProgressivo." AND FK_News = ".$id;
	$conn->query($sql);



	//move inputProgressivo to previousProgressivo
	$sql = "UPDATE img_news SET progressivo = ".$previousProgressivo." WHERE progressivo = ".$img." AND FK_News = ".$id;
	$conn->query($sql);

	//move dummyProgressivo to inputProgressivo
	$sql = "UPDATE img_news SET progressivo = ".$img." WHERE progressivo = 127 AND FK_News = ".$id;
	$conn->query($sql);

	header("Location: ../../editnews.php?id=".$id);

?>