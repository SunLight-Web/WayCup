<?php
include_once('../inc/dbConnect.php');
	// TODO:
	// SECURITY!!!!!!!!


if (($_POST['name'] == '') || !isset($_POST['price'])) {
	echo '{';
	echo '"success":false';
	echo '}';
} else {
	$name   = $_POST['name'];
	$price  = $_POST['price'];
	$query  = "INSERT INTO `rawMaterials` VALUES (0, '$name', '$price', 1)";
	if ($qry_result = $mysqli->query($query)){
		echo '{';
		echo '"success":true,';
		echo '"id":' . $mysqli->insert_id;
		echo '}';
	} else {
		echo '{';
		echo '"success":false';
		echo '}';
	}
}
$mysqli->close();

?>