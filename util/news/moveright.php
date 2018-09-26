<?php

	include("../phplib.php");


	$id = $img = "";

	!empty($_GET['id']) ? $id = $_GET['id'] : header("Location: ../../index.php");
	
	$img = $_GET['img'];


	//Get next Progressivo
	$sql = "SELECT Progressivo FROM img_news WHERE FK_News = ".$id." AND progressivo > ".$img." ORDER BY Progressivo LIMIT 1";

	$result = $conn->query($sql);

	$row = $result->fetch_assoc();

	$nextProgressivo = $row['Progressivo'];

	
	//move nextProrgessivo to dummyProgressivo
	$sql = "UPDATE img_news SET progressivo = 127 WHERE progressivo = ".$nextProgressivo." AND FK_News = ".$id;
	$conn->query($sql);



	//move inputProgressivo to nextProgressivo
	$sql = "UPDATE img_news SET progressivo = ".$nextProgressivo." WHERE progressivo = ".$img." AND FK_News = ".$id;
	$conn->query($sql);

	//move dummyProgressivo to inputProgressivo
	$sql = "UPDATE img_news SET progressivo = ".$img." WHERE progressivo = 127 AND FK_News = ".$id;
	$conn->query($sql);

	header("Location: ../../editnews.php?id=".$id);

?>