
<!-- login page -->

<?php  
	require("header.php");
?>
	<style>
	div#pad_left {
		padding-left: 20px;
	}
	</style>
	
	<div id="pad_left">
	<p>
		<h3>Home Page</h3>
	</p>		
	<!-- sort -->
	<form method="GET" action="<?=$_SERVER['PHP_SELF'];?>">
		<label class="lab">Sort by:</label>
		<select name="sort_by">
			<option value="Item Name">Item Name</option>
			<option value="Description">Description</option>
			<option value="Stock">Stock</option>
			<option value="Category">Category</option>
			<option value="Price">Price</option>
			<option value="Rating">Rating</option>
		</select>
		<select name="order">
			<option value="Ascending">Ascending</option>
			<option value="Descending">Descending</option>
		</select>
		<input type="submit" name="sort" value="Sort" />
	</form>
	</div>

	<main role="main">

	<div class="album py-5 bg-light">
	    <div class="container">
			<div class="row">
		<?php
		//code to display items
		//data from GET request
		$itemname_get = $_GET["itemname"]; // <- user's search query
		$filter_get = $_GET["filter"];
		$price_min_get = $_GET["price_min"];
		$price_max_get = $_GET["price_max"];
	
		//items.txt file
		$lines = file("database/items.txt", FILE_IGNORE_NEW_LINES);
	
		//print ("Search query: ".$itemname_get.", Filter: ".$filter_get);
		$num_items = count($lines);
	
		//do filtering first...	
		if (!empty($itemname_get) || !empty($filter_get)) 
		{
			for ($i = 0; $i < $num_items; $i++) 
			{
				$datas = explode(":", $lines[$i]); //split the line by colon		
				list($_, $itemname, $_, 
					$_, $_, $description, $_, 
					$category, $_, $_) = $datas;
					
				//unset lines that DON'T meet search criteria!
				if (!empty($filter_get) && $category != $filter_get) 
				{
					unset($lines[$i]); // <- doesn't require re-indexing!
				}
				if (!empty($itemname_get) && //if search query not found anywhere in...
					!preg_match("/{$itemname_get}/i", $itemname) && //the item name
					!preg_match("/{$itemname_get}/i", $description) && //the item's description
					!preg_match("/{$itemname_get}/i", $category)) { //or the item's category...
					unset($lines[$i]); // <- doesn't require re-indexing!
				}
			}		
		}
		//also do price range filtering if valid data for it supplied	
		if (!empty($price_min_get) && !empty($price_max_get)) 
		{ //html5 validation ensures numeric input...
			if ($price_min_get > $price_max_get) { //make sure low boundary does not exceed high boundary
				print ("Couldn't price_min_get > price_max_get!");
			}
			else 
			{
				for ($i = 0; $i < $num_items; $i++) 
				{
					$datas = explode(":", $lines[$i]); //split the line by colon		
					list($_, $_, $_, 
						$price, $_, $_, $_, 
						$_, $_, $_) = $datas;
					
					//unset lines/item that DON'T fall in price range
					if ($price < $price_min_get || $price > $price_max_get) {
						unset($lines[$i]); // <- doesn't require re-indexing!
					}				
				}
			}
		}
		
		//then do sorting...
		//<TODO>
		if(isset($_GET['sort'])) {		
			$sort_by = $_GET["sort_by"];
			$order = $_GET["order"];		
			$numeric = False;
			
			//key value pairs; map column numbers in database to options in dropdown
			$columns = ["Item Name"=>1, 
				"Description"=>5, 
				"Stock"=>8, 
				"Category"=>7, 
				"Price"=>3, 
				"Rating"=>0];
			//$sort_column gets a value from $columns
			$sort_column = $columns[$sort_by];

			//"|": delimiter being used to separate appended text from rest of string,
			//such as: "Cheryl|1:Cheryl:10-10-1992:F", where "1:Cheryl:10-10-1992:F" is
			//the base string.
			for ($i = 0; $i < $num_items; $i++) 
			{
				$datas = explode(":", $lines[$i]); //split string by delimiter, again
					
				//append the data we want to sort by to the front of the string
				$lines[$i] = $datas[$sort_column]."|".$lines[$i];
			}
			
			//check whether the data on which we sort on is numeric or not
			$numeric = is_numeric($datas[$sort_column]);
			
			//determine also if looking at text or numeric values, to ensure use of the right sort method
			if ($order == "Ascending") 
			{ //taking into account both ascending and descending sorting...			
				if ($numeric === False)
					sort($lines);
				else
					sort($lines, SORT_NUMERIC);
			}
			else if ($order == "Descending") 
			{
				if ($numeric === False)
					rsort($lines);
				else
					rsort($lines, SORT_NUMERIC);
			}				
			for ($i = 0; $i < $num_items; $i++) 
			{
				//finally, take off the appended text in front of each line of text, to
				//return each of the extracted lines to their original state
				$lines[$i] = substr($lines[$i], strpos($lines[$i], "|") + 1, strlen($lines[$i]));
			}
		}

		for ($i = 0; $i < $num_items; $i++) 
		{
			$datas = explode(":", $lines[$i]); //split the line by colon		
			list($itemid, $itemname, $photo, 
			$price, $userid_fk, $description_short, $description_long,
			$category, $quantity, $returnpolicy) = $datas;

			//unset array indices from the filtering earlier -> data in them becomes EMPTY, thus not shown
			if (!empty($itemid)) 
			{ 
				print 
				('<div class="col-md-4">
					<div class="card mb-4 shadow-sm">
						<div class="card-body">
							<b class="card-text">'.$itemname.'</b>
						</div>

						<img src="images/'.$itemid.'.jpg" height="300">

						<div class="card-body">
							<p class="card-text">'.$description_short.'</p>
							<p class="card-text">'.$category.'</p>
							<div class="d-flex justify-content-between align-items-center">
								<form method="POST" name="itemPage" action="homePage.php">
									<div class="btn-group">									
										<input type="submit" name="view" id="'.$itemid.'" class="btn btn-sm btn-outline-secondary" value="View Item / Purchase Item">
										<input type="hidden" name="id" value="'.$itemid.'" />
									</div>
								</form>

							<small class="text-muted">$'.$price.'</small>
							</div>

						</div>
					</div>
				</div>');
				/*
				print ('<td><img src="pictures/'.$itemid.'.jpg" style="width: 200px; height: 170px;">
				<br />
				'.$itemname.' 
				<div id="align_right">$'.$price.'</div>
				<br />
				'.$description_short.' 
				<br />
				'.$category.' 
				<br />
				Rating (Stars)
				<div id="align_right">'.$quantity.' in stock</div>
				</td>');
				*/
			}
		}
		
		if (isset($_POST['id'])) 
		{
			$_SESSION["itemPage_id"] = $_POST['id'];
			print ("<script>location.href='itemPage.php';</script>"); //redirect to itemPage.php
		}
		
		?>

	    </div>
	    </div>
	</div>

	</main>

<?php
    require("footer.php");
?>
