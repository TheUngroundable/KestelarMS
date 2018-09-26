<?php

	include("../phplib.php");

	$id = $img = "";

	!empty($_GET['img']) ? $img = $_GET['img'] : header("Location: ../../index.php");
	!empty($_GET['id']) ? $id = $_GET['id'] : header("Location: ../../index.php");

	$sql = "UPDATE img_news SET FK_News = NULL WHERE ID = ".$img;
	$result = $conn->query($sql);

	header("Location: ../../editnews.php?id=".$id);

?>