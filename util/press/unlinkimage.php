<?php

	include("../phplib.php");

	$id = $img = "";

	!empty($_GET['img']) ? $img = $_GET['img'] : header("Location: ../../index.php");
	!empty($_GET['id']) ? $id = $_GET['id'] : header("Location: ../../index.php");

	$sql = "UPDATE img_press SET FK_Press = NULL WHERE ID = ".$img;
	$result = $conn->query($sql);

	header("Location: ../../editpress.php?id=".$id);

?>