<?php 
if (isset($_GET['page']))
$pageID = $_GET['page'];
else
$pageID = 0;
 ?>

<?php include('pageManager.php'); ?>
<?php $pagetitle = $navElements[$pageID]->name;	 ?>
<?php include('header.php'); 	 ?>
<?php include('navigation.php'); ?>


<?php 
if (file_exists($navElements[$pageID]->href)){
	include($navElements[$pageID]->href);
} else {
	include('404.php');
}

 ?>


<?php include('footer.php'); 	 ?>