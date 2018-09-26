<?php

	include("../phplib.php");

	$id = !empty($_GET['id']) ? $_GET['id'] : header("Location: ../../managecategory.php");

	$sql = "DELETE FROM categoria WHERE ID = ".$id;

	$conn->query($sql);

	header("Location: ../../managecategory.php");

?>