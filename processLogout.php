
<!-- process request from logout button -->

<?php  
	session_start();
	unset($_SESSION);
	session_destroy();

	// then redirect to home page
	require("homePage.php");
?>
