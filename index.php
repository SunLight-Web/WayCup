<?php
include("inc/header.php");  

if (SETUP_MODE) {           
	include("inc/setup.php");		  
} else {		

	if ('in' == $logged){
		header("Location: crm/");
	} else {
	 	include("inc/login.php");	  
	}
}  						  
	include("inc/footer.php");  
?>
 