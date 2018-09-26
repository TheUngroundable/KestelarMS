<?php

	include("../phplib.php");

	$id = !empty($_GET['id']) ? $_GET['id'] : header("Location: ../../managenews.php");

	//remove single image from server

	$sql = "SELECT img_news.Percorso as Percorso, img_news.ID as ID FROM img_news WHERE img_news.FK_News = ".$id;

	$result = $conn->query($sql);

	while($row = $result->fetch_array()){

		//remove image from DB

		$query = "UPDATE img_news SET FK_News = NULL WHERE ID = ".$row['ID'];

		$conn->query($query);

	}



	//remove press content 

	$sql = "DELETE FROM contenuto_news WHERE FK_News = ".$id;

	$conn->query($sql);

	//remove press

	$sql = "DELETE FROM news WHERE ID = ".$id;

	$conn->query($sql);

	header("Location: ../../managenews.php");

?>