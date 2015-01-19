<?php
include_once('../inc/dbConnect.php');
	// TODO:
	// SECURITY!!!!!!!!


if (!isset($_POST['cardnum'])) {
	$cardnum = 0;
} else {
	$cardnum = $_POST['cardnum'];
	$cardnum = $mysqli->real_escape_string($cardnum);
	$query   = "SELECT `id`, `coffees` FROM `clients` WHERE `card` = '$cardnum'";
	$qry_result = $mysqli->query($query);
	if ($qry_result->num_rows <> 0) {
		$row = mysqli_fetch_array($qry_result);
		$clientID = $row['id'];
	} else {
		$clientID = 0;
	}
	$newCoffees = $row['coffees'];
	
	if (isset($_POST['coffees'])) {
		$newCoffees += $_POST['coffees'];
	}
}


if (isset($_POST['cash'])){
	$cash = $_POST['cash'];
} else {
	$cash = 0;
}
setlocale(LC_ALL, 'rus');
date_default_timezone_set('Europe/Moscow');
$timecode = date('Y-m-d H:i:s');

if (!isset($_POST['idset'])) {
	echo "ЗАКАЗ ПУСТОЙ, ИДИ НАХУЙ!";
} else {
	$idset = $_POST['idset'];
	$idset = $mysqli->real_escape_string($idset);
	$query  = "INSERT INTO `check` VALUES (0, '$clientID', '$idset', '$cash', '$timecode')";
	$query1 = "UPDATE `clients` SET `coffees` = '$newCoffees' WHERE `id` = '$clientID'"; 
	//Execute query
	if (($qry_result = $mysqli->query($query)) && ($qry1_result = $mysqli->query($query1))){
		echo 'Заебись! Схоронил чек по карте #' . $cardnum;
	} else {
		echo 'Всё очень хуёво. Очень хуёво.';
	}
}
$mysqli->close();

?>