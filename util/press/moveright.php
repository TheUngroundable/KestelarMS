<?php

	include("../phplib.php");


	$id = $img = "";

	!empty($_GET['id']) ? $id = $_GET['id'] : header("Location: ../../index.php");
	
	$img = $_GET['img'];


	//Get next Progressivo
	$sql = "SELECT Progressivo FROM img_press WHERE FK_Press = ".$id." AND progressivo > ".$img." ORDER BY Progressivo LIMIT 1";

	$result = $conn->query($sql);

	$row = $result->fetch_assoc();

	$nextProgressivo = $row['Progressivo'];

	
	//move nextProrgessivo to dummyProgressivo
	$sql = "UPDATE img_press SET progressivo = 127 WHERE progressivo = ".$nextProgressivo." AND FK_Press = ".$id;
	$conn->query($sql);



	//move inputProgressivo to nextProgressivo
	$sql = "UPDATE img_press SET progressivo = ".$nextProgressivo." WHERE progressivo = ".$img." AND FK_Press = ".$id;
	$conn->query($sql);

	//move dummyProgressivo to inputProgressivo
	$sql = "UPDATE img_press SET progressivo = ".$img." WHERE progressivo = 127 AND FK_Press = ".$id;
	$conn->query($sql);

	header("Location: ../../editpress.php?id=".$id);

?>