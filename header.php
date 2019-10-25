<?php
	//bring in code from this script to several pages (i.e. index, browse, etc.)
	error_reporting(0);	
	print ("username: ".$_SESSION['username'].'<br />');
	
	$isLoggedIn = (isset($_SESSION['username']));

	$host = 'localhost';
	$user = 'root';
	$passwd = '';

	$itemname = $_GET["itemname"];
	$fieldToSort = $_GET["fieldToSort"];
	$filter = $_GET["filter"];

	$userid = 0; //placeholder value

	//when clicking log out:
	if(isset($_POST['logout'])) {
		// remove all session variables, then destroy session
		session_unset();
		session_destroy();
		header('location: '.$_SERVER["PHP_SELF"]);
		exit();
	}
	//when clicking sell item:
	if(isset($_POST['sell'])) {
		// remove all session variables, then destroy session
		header('location: post_item.php');
	}	
	
	
    //when user is logged in:
	if(isset($_SESSION['username'])) {
		print ("logged in!!<br />");
		$userid = $_SESSION['userid'];
	}
	else {
		print ("NOT logged in!!<br />");
	}

	$username = 'null';
	//if logged in...
	if ($isLoggedIn) {
		print ("<form method='POST' action=".$_SERVER['PHP_SELF'].">
			Welcome back, ".$_SESSION['firstname']."!
			<input type='submit' name='logout' value='Log Out' />
			<input type='submit' name='sell' value='Sell an item' />
		</form>");
	}
	//otherwise...
	else {
		print ('<button onclick="window.location.href=\'login.php\';">Log in</button> ');
		print ('<button onclick="window.location.href=\'register.php\';">Register</button> ');
	}
?>