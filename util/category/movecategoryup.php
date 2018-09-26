<?php 

	include("../phplib.php");

	$inputID = !empty($_GET['id']) ? $_GET['id'] : header("Location: ../../managecategory.php");

	//Get previous ID
	$sql = "SELECT ID FROM categoria WHERE ID < ".$inputID." ORDER BY ID DESC LIMIT 1";

	$result = $conn->query($sql);

	$row = $result->fetch_assoc();

	$previousID = $row['ID'];


	//move previousID to dummyID
	$sql = "UPDATE categoria SET ID = ".PHP_INT_MAX." WHERE ID = ".$previousID;
	$conn->query($sql);


	//move inputID to previousID
	$sql = "UPDATE categoria SET ID = ".$previousID." WHERE ID = ".$inputID;
	$conn->query($sql);

	//move dummyID to inputID
	$sql = "UPDATE categoria SET ID = ".$inputID." WHERE ID = ".PHP_INT_MAX;
	$conn->query($sql);

	header("Location: ../../managecategory.php");

?>