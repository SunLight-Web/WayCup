<?php
include_once('../inc/dbConnect.php');
	// TODO:
	// SECURITY!!!!!!!!

if (isset($_POST['cash'])){
	$cash = $_POST['cash'];
} else {
	$cash = 0;
}
setlocale(LC_ALL, 'rus');
date_default_timezone_set('Europe/Moscow');
$timecode = date('Y-m-d H:i:s');

if (!isset($_POST['idset'])) {
	echo "ЧЕК ПУСТОЙ!";
} else {
	$idset = $_POST['idset'];
	$baristaId = $_POST['barista'];
	$idset = $mysqli->real_escape_string($idset);
	$query  = "INSERT INTO `expenses` VALUES (0, '$baristaId', '$idset', '$cash', '$timecode')";

	//Execute query
	if ($qry_result = $mysqli->query($query)){
		echo 'Отлично! Всем спасибо, чек сохранён.';
	} else {
		echo 'Всё очень плохо. Очень плохо.';
	}
}
$mysqli->close();

?>