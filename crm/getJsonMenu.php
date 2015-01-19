<?php
include('../inc/dbConnect.php');
include('menu_items.php');
echo json_encode($menu);
$mysqli->close();
?>