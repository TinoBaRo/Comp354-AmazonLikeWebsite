
<!-- postItemPage.php -->
<style>
div#pad_left 
{
	padding-left: 20px;
}
</style>

<?php
	require("header.php");
	$isLoggedIn = (session_status() == isset($_SESSION['username']));
	error_reporting(0);
	
	//if not logged in, deny access...
	if (!$isLoggedIn) {
		//block off page access
		print ('must be logged in to sell items!<br />');
		print ("<form method='POST' action=".$_SERVER['PHP_SELF'].">
		<input type='submit' name='index' value='Back to homepage' />
		</form><br />");
		die();
	}
	
	//when clicking back to index:
	if(isset($_POST['index'])) {
		header('location: homePage.php');
	}	
?>
	<div class="py-5 text-center">
		<img src="logo354TheStars.png" height="200" width="300">
	    <h2>Post New Item</h2>
	    <h4>Enter the following information</h4>
	</div>
<?php
	if(isset($_POST['sell'])) {
		//gather all of the input data, and make sure nothing important is missing
		
		//first, get id from last line of data in items table, 
		//then increment it by 1 to ensure all future ids will always
		//be unique
		$lines = file("database/items.txt", FILE_IGNORE_NEW_LINES);
		$next_id = explode(":", $lines[count($lines) - 1])[0] + 1;

		$category = $_POST["filter"];
		$itemname = $_POST["itemname"];
		$price    = $_POST["price"];
		$stock    = $_POST["stock"]; //how many are being sold?
		
		$userid = $_SESSION['userid'];

		//text fields
		$description_short = $_POST["description_short"];
		$description_long  = $_POST["description_long"];
		$return_policy     = $_POST["return_policy"];

		//show the item image
		$filepath = "images/".$_FILES["file"]["name"];

		$extension = pathinfo($filepath, PATHINFO_EXTENSION);
		
		if (move_uploaded_file($_FILES["file"]["tmp_name"], $filepath)) {
			rename($filepath, "images/" .$next_id. "." .$extension); //we need this or not?
		}
		
		$delimiter = ':';
		
		//get ready to add the item to database
		$new_item_line = 
			$next_id . $delimiter .
			$itemname . $delimiter .
			$next_id . "." . $extension . $delimiter . // <- images will be renamed with next_id, extension
			$price . $delimiter .
			$userid . $delimiter .
			$description_short . $delimiter .
			$description_long . $delimiter .
			$category . $delimiter .
			$stock . $delimiter .
			$return_policy.PHP_EOL;
			
		//print ("item: ".$new_item_line);
		
		//write this line to items file
		$items_table = fopen("database/items.txt", "a+");
		fwrite($items_table, $new_item_line);
		fclose($items_table);

		print ("<div class=\"mx-auto\" style=\"width: 800px;\"> Item posting for '.$itemname.' created successfully!<br />");
		print ("
		<a href=\"homePage.php\" class=\"btn btn-primary\" role=\"button\">Return Home</a>
		</div>");

		die();
	}

	
    //when user is logged in:
	if(isset($_SESSION['username']) && !empty($_SESSION['password'])) {
		$token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));

  		if($isLoggedIn) 
  		{
			$userid = $_SESSION['userid'];
		}
	}

?>
</div>
</head>

<hr>

<div class="mx-auto" style="width: 800px;">
		<form method='POST' enctype="multipart/form-data">
			Item Name<br />
			<input type="text" name="itemname" required></input><br />
			Price ($)<br />
			<input type="number" name="price" step="0.01" min="0.01" required></input><br />
			Stock<br />
			<input type="number" name="stock" step="1" min="1" required><br /> <!-- whole numbers only -->
			Category<br />
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
			</select><br />
			Upload Photo<br />
			<input type="file" name="file" accept="image/*"><br />
			Short Description<br />
			<textarea rows="4" cols="50" name="description_short"></textarea><br />
			Full Description<br />
			<textarea rows="12" cols="50" name="description_long"></textarea><br />
			Return Policy<br />
			<textarea rows="6" cols="50" name="return_policy"></textarea><br />
			<br />
			<input type="submit" name="sell" value="Post" />
		</form>
		<br/>
</div>


<!-- don't need the other footer -->
 	</body>
</html>

