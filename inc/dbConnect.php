<?php
include("config.php");      
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
$mysqli->set_charset("utf8");


// Uncomment for init
            // for ($i=0; $i < 1000; $i++) { 
            //   $stmt = $mysqli->prepare("INSERT INTO `clients` (card) VALUES (?)");
            //   $stmt->bind_param('i', $i);
            //   $stmt->execute();
            // }