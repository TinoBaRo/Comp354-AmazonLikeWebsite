<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head><title>354 The Stars - Search</title>
<!--
<link rel="stylesheet" type="text/css" href="css/main.css" />
-->
<div id="header">
<h1>354TheStars - Browse items</h1>
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
	<label class="lab">Sort by:</label>
	<select name="fieldToSort">
		<option value="itemname_sort">Item Name</option>
		<option value="description">Description</option>
		<option value="stock">Stock</option>
		<option value="category">Category</option>
		<option value="price">Price</option>
		<option value="rating">Rating</option>
	</select>
	<select name="order">
		<option value="ascending">Ascending</option>
		<option value="descending">Descending</option>
	</select>
	<input type="submit" value="Sort" />	
	<br />

<style>
table {
  font-family: Arial, sans-serif;
  border-collapse: collapse;
  width: 75%;
}
td, th {
  border: 1px solid #222222;
  text-align: left;
  padding: 6px;
  width: 100px;
}
div#align_right {
	text-align: right;
}

</style>

<?php
    //print the data from GET request
	$itemname_get = $_GET["itemname"]; // <- user's search query
	$filter_get = $_GET["filter"];
	
	//items.txt file
	$lines = file("database/items.txt", FILE_IGNORE_NEW_LINES);
	
	print ("Search query: ".$itemname_get.", Filter: ".$filter_get);
	$num_items = count($lines);
	
	//do filtering first...
	if (!empty($itemname_get) || !empty($filter_get)) {
		for ($i = 0; $i < $num_items;) {
			$datas = explode(":", $lines[$i]); //split the line by colon		
			list($_, $itemname, $_, 
				$_, $_, $description, $_, 
				$category, $_, $_) = $datas;
				
			//unset lines that DON'T meet search criteria!
			if (!empty($filter_get) && $category != $filter_get) {
				unset($lines[$i]); // <- doesn't require re-indexing!
			}
			if (!empty($itemname_get) && //if search query not found anywhere in...
				!preg_match("/{$itemname_get}/i", $itemname) && //the item name
				!preg_match("/{$itemname_get}/i", $description) && //the item's description
				!preg_match("/{$itemname_get}/i", $category)) { //or the item's category...
				unset($lines[$i]); // <- doesn't require re-indexing!
			}
			$i++;
		}		
	}
	//then do sorting...
	//<TODO>

	print ('<table><tr>');
	for ($i = 0; $i < $num_items; $i++) {
		$datas = explode(":", $lines[$i]); //split the line by colon		
		list($itemid, $itemname, $photo, 
			 $price, $userid_fk, $description_short, $description_long,
			 $category, $quantity, $returnpolicy) = $datas;

		//unset array indices from the filtering earlier -> data in them becomes EMPTY, thus not shown
		if (!empty($itemid)) { 
			print ('<td><img src="pictures/'.$itemid.'.jpg" style="width: 200px; height: 170px;">
			<br />
			'.$itemname.' 
			<div id="align_right">$'.$price.'</div>
			<br />
			'.$description.' 
			<br />
			'.$category.' 
			<br />
			Rating (Stars)
			<div id="align_right">'.$quantity.' in stock</div>
			</td>');
		}
	}
	print ('</tr></table>');
?>

</body>

<footer>
	<address><center>footer text</center></address>
</footer>