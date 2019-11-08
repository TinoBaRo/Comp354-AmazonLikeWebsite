
<!-- process request from logout button -->

<?php  
	// get session data
	session_start();

	// unset and destroy
	unset($_SESSION);
	session_destroy();

	// then redirect to home page
	//require("homePage.php");
	header("location: homePage.php");	
?>
