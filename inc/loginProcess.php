<?php
include('dbConnect.php');
include('functions.php');

wcp_session_start();

if (isset($_POST['username'], $_POST['p'])) {
	$username = $_POST['username'];
	$password = $_POST['p'];

	if (login($username, $password, $mysqli) == true) { 
		// Loggin success
		header('Location: ../crm/');
	} else {
		// Fayuol
		header('Location: ../index.php?error=1');
	}
} else {
	echo 'Something went terribly wrong.';
}
?>