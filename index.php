<?php
session_start();
?>

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
<form method="GET" action="browse.php">
	<label class="lab">Search for:</label>
	<input name="itemname" type="text" />
	<select name="filter">
		<option value="">-select a category-</option>
		<option value="Books">Books</option>
		<option value="Clothing">Clothing</option>
		<option value="Collectibles">Collectibles</option>
		<option value="Electronics">Electronics</option>
		<option value="Fashion Accessories">Fashion Accessories</option>
		<option value="Hardware Supplies">Hardware Supplies</option>
		<option value="Health & Care">Health & Care</option>
		<option value="Household Products">Household Products</option>
		<option value="Instruments">Instruments</option>
		<option value="Music">Music</option>
		<option value="Sports">Sports</option>
		<option value="Toys">Toys</option>
		<option value="Vehicles">Vehicles</option>
		<option value="Video Games">Video Games</option>
	</select>
	<input type="submit" value="Search" />	
</form>

<!-- The php code for the head of several key pages -->
<?php include 'header.php';?>

</div>
</head>
<hr>
<body>
the body of the index page will go here

<?php
	error_reporting(0); //disables notices of undefined indices

	die();
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
?>
</body>

<footer>
	<address><center>footer text</center></address>
</footer>