<!DOCTYPE html>
<html>
<head><title>354 The Stars - Index</title>
<!--
<link rel="stylesheet" type="text/css" href="css/main.css" />
-->
<div id="header">
<h1>354TheStars main page</h1>
<!-- 
sorting to be moved to item displaying page/off of main page
-->
<form method="GET" action="">
	<label class="lab">Search for:</label>
	<input name="itemname" type="text" />
	<!--
	<label class="lab">Sort by:</label>
	<select name="fieldToSort">
		<option value="itemid">Item ID</option>
		<option value="itemname">Item Name</option>
		<option value="description">Description</option>
		<option value="stock">Stock</option>
		<option value="category">Category</option>
		<option value="price">Price</option>
	</select><br />
	-->
	<select name="filter">
		<option value="">-select a category-</option>
		<option value="Books">Books</option>
		<option value="Clothing">Clothing</option>
		<option value="Collectibles">Collectibles</option>
		<option value="Electronics">Electronics</option>
		<option value="Fashion">Fashion Accessories</option>
		<option value="Hardware">Hardware Supplies</option>
		<option value="Health">Health & Care</option>
		<option value="Household">Household Products</option>
		<option value="Instruments">Instruments</option>
		<option value="Music">Music</option>
		<option value="Sports">Sports</option>
		<option value="Toys">Toys</option>
		<option value="Vehicles">Vehicles</option>
		<option value="Video_Games">Video Games</option>
	</select>
	<input type="submit" value="Search" />	
</form>

<?php
	$isLoggedIn = (session_status() == PHP_SESSION_ACTIVE);
	print ("is logged in? ".$isLoggedIn.PHP_EOL);

	error_reporting(0);
	
	$host = 'localhost';
	$user = 'root';
	$passwd = '';

	$itemname = $_GET["itemname"];
	$fieldToSort = $_GET["fieldToSort"];
	$filter = $_GET["filter"];

	$userid = 0; //placeholder value
	
	//when clicking log in:
	if(isset($_POST['login'])) {
	    header('location: login.php');
	}
	//when clicking register:
	if(isset($_POST['register'])) {
	    header('location: register.php');
	}
	//when 
	if(isset($_POST['logout'])) {
		session_destroy();
	}
	
    //when user is logged in:
	if(isset($_SESSION['username']) && !empty($_SESSION['password'])) {
		$token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));

  		if($isLoggedIn) {
			$userid = $_SESSION['userid'];
		}
	}

	$username = 'null';
	//if logged in...
	if ($isLoggedIn) {
		print ('Welcome back, '.$username.'! ');
		print ('<button>Log Out</button> ');
	}
	//otherwise...
	else {
		print ('<button onclick="window.location.href=\'login.php\';">Log in</button> ');
		print ('<button onclick="window.location.href=\'register.php\';">Register</button> ');
	}

?>
</div>
</head>

<hr>

<body>
the body of the pages will go here

<?php
	error_reporting(0); //disables notices of undefined indices

	//_select SQL statement
	$selectQuery = "SELECT * FROM items ";

	if ($itemname != null || $filter != null)
		$selectQuery .= " WHERE";
		//if either search query or category is not empty we need a where clause
	if ($itemname != null)
		$selectQuery .= " itemname LIKE '%$itemname%' AND";
	if ($filter != null)
		$selectQuery .= " category='$filter' AND";
	if ($itemname != null || $filter != null)
		$selectQuery = substr($selectQuery, 0, strlen($selectQuery)-4);
		//trim off the last AND in statement
	if ($fieldToSort != null)
		$selectQuery .= " ORDER BY $fieldToSort";

	print ("<table><div class='menu'>
		<ul id='dc_mega-menu-orange' class='dc_mm-orange'>");

	if($login->isLoggedIn() ) {
		//get the number of items in a users cart
		$getCnt = $mysqli->prepare("SELECT * FROM orders WHERE userid=$userid AND orderstatus='pending'");
		$getCnt->execute();
		$getCnt->store_result();
		$count = $getCnt->num_rows;
		if ($count == 1)
			$value = "View Cart ($count item)";
		else
			$value = "View Cart ($count items)";
		print ("<li><a href='cart.php'>$value</a></li>");
	}
	print ("<li><a href='main.php'>Back to Home</a></li>");
	if($login->isLoggedIn() ) {
		print ("<li><a href='order_history.php'>View Order History</a></li>".
			"<li><a href='user_control.php'>User Control Panel</a></li>");
	}
	//display the login or logout buttons
	if($login->isLoggedIn() ) {
		print ("<li><a>
				<form method='POST' action=''>
			<input type='submit' name='logout' value='Logout' />
			</form></a></li>");
	}
	else {
		print ("<li><a>
				<form method='POST' action='login.php'>
			<input type='submit' name='lindex' value='Login' />
			</form></a></li>");
		print ("<li><a href='register.php'>Register</a></li>");
	}
	print ("<div class='clear'></div></ul></table>");
?>
</body>

<footer>
	<address><center>footer text</center></address>
</footer>