<?php 

	include("../phplib.php");

	$inputID = !empty($_GET['id']) ? $_GET['id'] : header("Location: ../../managecategory.php");

	//Get Next ID
	$sql = "SELECT ID FROM categoria WHERE ID > ".$inputID." ORDER BY ID LIMIT 1";

	$result = $conn->query($sql);

	$row = $result->fetch_assoc();

	$nextID = $row['ID'];


	//move nextID to dummyID
	$sql = "UPDATE categoria SET ID = ".PHP_INT_MAX." WHERE ID = ".$nextID;
	$conn->query($sql);


	//move inputID to nextID
	$sql = "UPDATE categoria SET ID = ".$nextID." WHERE ID = ".$inputID;
	$conn->query($sql);

	//move dummyID to inputID
	$sql = "UPDATE categoria SET ID = ".$inputID." WHERE ID = ".PHP_INT_MAX;
	$conn->query($sql);

	header("Location: ../../managecategory.php");

?>