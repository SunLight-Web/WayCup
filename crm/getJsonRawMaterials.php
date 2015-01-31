<?php
include('../inc/dbConnect.php');
include('raw_items.php');
echo json_encode($items);
$mysqli->close();
?>