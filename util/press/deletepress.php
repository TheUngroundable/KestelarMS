<?php

	include("../phplib.php");

	$id = !empty($_GET['id']) ? $_GET['id'] : header("Location: ../../managepress.php");

	//remove single image from server

	$sql = "SELECT img_press.Percorso as Percorso, img_press.ID as ID FROM img_press WHERE img_press.FK_Press = ".$id;

	$result = $conn->query($sql);

	while($row = $result->fetch_array()){

		//remove image from DB

		$query = "UPDATE img_press SET FK_Press = NULL WHERE ID = ".$row['ID'];

		$conn->query($query);

	}


	//remove press content 

	$sql = "DELETE FROM contenuto_press WHERE FK_Press = ".$id;

	$conn->query($sql);

	//remove press

	$sql = "DELETE FROM press WHERE ID = ".$id;

	$conn->query($sql);

	header("Location: ../../managepress.php");

?>