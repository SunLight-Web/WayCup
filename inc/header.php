<?php 
include_once('inc/dbConnect.php');
include_once('inc/functions.php');
wcp_session_start();

if (isLoggedIn($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Way Cup Coffee</title>
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="css/style.css" rel="stylesheet" media="screen">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/JavaScript" src="js/sha512.js"></script> 
    <script type="text/JavaScript" src="js/forms.js"></script> 
  </head>
  <body>
     <div class="container login-container">
    <div class="logo-top-block">
      <a href="index.php"></a>
    </div>
