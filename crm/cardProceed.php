<?php
include_once('../inc/dbConnect.php');
	// TODO:
	// SECURITY!!!!!!!!

	// Retrieve data from Query String
$cardnum = $_GET['cardnum'];

	// Escape User Input to help prevent SQL Injection
$cardnum = $mysqli->real_escape_string($cardnum);
	
$query = "SELECT * FROM clients WHERE card = '$cardnum'";

	//Execute query
$qry_result = $mysqli->query($query);	
	echo '{';
	if ($qry_result->num_rows <> 0) {
		$row = mysqli_fetch_array($qry_result);

		echo '"name":"' . $row['name'] . '",';
		echo '"coffees":"' . $row['coffees'] . '",';
		echo '"bonuses":"' . $row['coffees']%6 . '"';
 	} else {
		echo "noElements: true";
	}
	echo '}';
$mysqli->close();
?>