
<!-- login page -->

<?php  
	require("header.php");
	include("computeRating.php");
?>
	<style>
		#pad_left {
			padding-left: 15px;
			padding-right: 15px;
		}

		
	</style>
	

	<div id="pad_left">
		<p>
			<h3>Home Page</h3>
		</p>		

		<!-- Sort buttons -->
		<p>
			<form method="GET" class="form-inline" action="<?=$_SERVER['PHP_SELF'];?>">
				<label class="lab">Sort by:&nbsp;</label>
				<select class="form-control" style="max-width: 150px" name="sort_by">
					<option value="Item Name">Item Name</option>
					<option value="Description">Description</option>
					<option value="Stock">Stock</option>
					<option value="Category">Category</option>
					<option value="Price">Price</option>
					<option value="Rating">Rating</option>
				</select>&nbsp;
				<select class="form-control" style="max-width: 150px" name="order">
					<option value="Ascending">Ascending</option>
					<option value="Descending">Descending</option>
				</select>
				&nbsp;&nbsp;
				<input type="submit" class="btn btn-sm btn-outline-secondary" name="sort" value="Sort" />
			</form>
		</p>
		

		<!-- TABLE below header -->
		<table>
		<tr>
			<!-- video advertisements -->
			<th>
			<p>
				<video width = "470" height = "200" autoplay="autoplay" muted ="muted" >
			      <source src = "ad_TheNorthFace_Jacket.mp4">
			      <source src = "ad_TheNorthFace_Jacket.ogv"> 
			      <source src = "ad_TheNorthFace_Jacket.webm"> 
			      Your browser does not support the video element
		    	</video>
	    	</p>
	    	</th>

	    	<th>
			<p>
				<video width = "470" height = "200" autoplay="autoplay" muted ="muted" >
			      <source src = "ad_TheNorthFace_Jacket.mp4">
			      <source src = "ad_TheNorthFace_Jacket.ogv"> 
			      <source src = "ad_TheNorthFace_Jacket.webm"> 
			      Your browser does not support the video element
		    	</video>
	    	</p>
	    	</th>

	    	<th>
			<p>
				<video width = "470" height = "200" autoplay="autoplay" muted ="muted" >
			      <source src = "ad_TheNorthFace_Jacket.mp4">
			      <source src = "ad_TheNorthFace_Jacket.ogv"> 
			      <source src = "ad_TheNorthFace_Jacket.webm"> 
			      Your browser does not support the video element
		    	</video>
	    	</p>
	    	</th>

	    </tr>
		</table>

	</div> <!-- Section including 'Home Page' -->
	

	<!-- new line -->
	<br/>

	<main role="main">

	<div class="album py-5 bg-light">
	    <div class="container">
			<div class="row">
		<?php
		$get_url = '';
		
		//code to display items
		//data from GET request
		$itemname_get = $_GET["itemname"]; // <- user's search query
		$filter_get = $_GET["filter"];
		$price_min_get = $_GET["price_min"];
		$price_max_get = $_GET["price_max"];
		
		//special means of filtering, activated from index page
		//view order history by retrieving orders data, orders.txt file
		$order_lines = file("database/orders.txt", FILE_IGNORE_NEW_LINES);
		$num_orders = count($order_lines);
				
		//items.txt file
		$lines = file("database/items.txt", FILE_IGNORE_NEW_LINES);
		$num_items = count($lines);
		
		//users.txt file
		$user_lines = file("loginData.txt", FILE_IGNORE_NEW_LINES);
		$num_users = count($user_lines);
		
		$matching_items = $num_items;
		
		//best sellers...
		if(isset($_GET['best_sellers'])) {
			$get_url = 'best_sellers='.$banner_strings[0].'&';
			
			//find the top seller(s)
			$seller_ids = array();
			
			for ($i = 0; $i < $num_orders; $i++) {
				$order_datas = explode(":", $order_lines[$i]); //split the line by colon		
				list($_, $seller_id_fk, $_, $_, $_, $_) = $order_datas;
				
				array_push($seller_ids, $seller_id_fk);
			}
			
			//get the most commonly occurring seller id out of this array...
			$counts = array_count_values($seller_ids);
			arsort($counts);
			//best sellers: people whose items were bought the most; 1: get only 1 seller
			$best_sellers_by_id = array_slice(array_keys($counts), 0, 1, true);

			for ($i = 0; $i < $num_items; $i++) {
				$datas = explode(":", $lines[$i]); //split the line by colon		
				list($_, $_, $_, 
					$_, $userid_fk, $_, $_, 
					$_, $_, $_) = $datas;

				//unset lines if the item's user/seller id is NOT in list of best sellers!
				if (!in_array(($userid_fk), $best_sellers_by_id)) {
					unset($lines[$i]); // <- doesn't require re-indexing!
					$matching_items -= 1;
				}
			}	
		}
		
		//newest items query...
		if(isset($_GET['new_items'])) {
			$get_url = 'new_items='.$banner_strings[1].'&';
			
			//show only items posted in past 14 days...
			$days_recent = 14; //days ago considered RECENT specifiable here...		
			$past_days_ago = strtotime("-".$days_recent." Days");

			for ($i = 0; $i < $num_items; $i++) {
				$datas = explode(":", $lines[$i]); //split the line by colon
				list($_, $_, $_, 
					$_, $_, $_, $_, 
					$_, $_, $_, $posted_date) = $datas;

				//unset lines if the item's posted date is before 14 days before today, or over 2 weeks old
				if (strtotime($posted_date) < $past_days_ago) {
					unset($lines[$i]); // <- doesn't require re-indexing!
					$matching_items -= 1;
				}
			}
		}

		//most popular categories...
		if(isset($_GET['best_categories'])) {
			$get_url = 'best_categories='.$banner_strings[2].'&';
			
			//find the top category(s)
			$item_categories = array();
			
			for ($i = 0; $i < $num_orders; $i++) {
				$order_datas = explode(":", $order_lines[$i]); //split the line by colon		
				list($_, $_, $_, $_, $category_, $_) = $order_datas;

				array_push($item_categories, $category_);
			}
			
			//get the most commonly occurring category out of this array...
			$counts = array_count_values($item_categories);
			arsort($counts);
			//best sellers: people whose items were bought the most; 1: get only 1 seller
			$best_categories = array_slice(array_keys($counts), 0, 1, true);

			for ($i = 0; $i < $num_items; $i++) {
				$datas = explode(":", $lines[$i]); //split the line by colon		
				list($_, $_, $_, 
					$_, $_, $_, $_, 
					$category, $_, $_) = $datas;

				//unset lines similar to best seller logic...
				if (!in_array($category, $best_categories)) {
					unset($lines[$i]); // <- doesn't require re-indexing!
					$matching_items -= 1;
				}
			}	
		}
	
		//do filtering first...	
		if (!empty($itemname_get) || !empty($filter_get))
		{
			$get_url .= 'filter='.$filter_get.'&itemname='.$itemname_get.'&';
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
					$matching_items -= 1;
				}
				if (!empty($itemname_get) && //if search query not found anywhere in...
					!preg_match("/{$itemname_get}/i", $itemname) && //the item name
					!preg_match("/{$itemname_get}/i", $category)) { //or the item's category...
					unset($lines[$i]); // <- doesn't require re-indexing!
					$matching_items -= 1;
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
				$get_url .= 'price_min='.$price_min_get.'&price_max='.$price_max_get.'&';
				for ($i = 0; $i < $num_items; $i++) 
				{
					$datas = explode(":", $lines[$i]); //split the line by colon		
					list($_, $_, $_, 
						$price, $_, $_, $_, 
						$_, $_, $_) = $datas;
					
					//unset lines/item that DON'T fall in price range
					if ($price < $price_min_get || $price > $price_max_get) {
						unset($lines[$i]); // <- doesn't require re-indexing!
						$matching_items -= 1;
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

		//every item id for an item that met search criteria goes in $ids...
		$ids = array();
		for ($i = 0; $i < $num_items; $i++)  {
			$datas = explode(":", $lines[$i]); //split the line by colon		
			list($itemid, $itemname, $photo, 
			$price, $userid_fk, $description_short, $description_long,
			$category, $quantity, $returnpolicy) = $datas;
			
			if (!empty($itemid)) { 
				array_push($ids, $itemid);
			}
		}
		
		//pagination variables
		$current_page = $_GET["current_page"]; 

		// set current page to 1 if click on home page
		if( $current_page == null) {
			$current_page = 1;
		}

		// set previous, next and nb of pages
		$previous_page = $current_page - 1;
		$next_page = $current_page + 1;
		$items_per_page = 6;
		$num_page = ceil($matching_items / $items_per_page);
		
		// set counter limit based on current page
		$total_items_for_loop = ($current_page != $num_page ? $current_page * $items_per_page : $matching_items);

		for ($i = ($current_page - 1) * $items_per_page; $i < $total_items_for_loop; $i++) 
		{
			$whichLine = $ids[$i]; //look for each item using its id from $ids rather than iterative index
			
			$datas = explode(":", $lines[$whichLine - 1]); //split the line by colon	
			list($itemid, $itemname, $photo, 
			$price, $userid_fk, $description_short, $description_long,
			$category, $quantity, $returnpolicy) = $datas;
			
			//get user data also
			$user_datas = explode(":", $user_lines[$userid_fk - 1]); 
			list($userid_pk, $username, $_, $_, $_, $_) = $user_datas;

			//unset array indices from the filtering earlier -> data in them becomes EMPTY, thus not shown
			if (!empty($itemid)) 
			{ 
				$rating_stars = getRating($itemid);
				
				if ($rating_stars > 0) { //calculate rating out of 5 only if necessary
					$rating_line = ($rating_stars . '</small> out of 5 stars</p>');
				}
				else {
					$rating_line = "Not yet rated";
				}
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
							<p class="card-text">Sold by: '.$username.'</p>
							<p class="card-text"><img src="images/star_full.jpg" style="width: 20px;"/> '.$rating_line.'</p>
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
			}
		}
		//if we found nothing with the given search query
		if ($matching_items === 0) {
			if (!empty($itemname_get)) {
				print ("<h3>No results found for ".$itemname_get.".</h3>");
			}
			else if (!empty($filter_get)) {
				print ("<h3>No items found in ".$filter_get." category.</h3>");
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

	<!-- new line -->
	<br/>

	<!-- More Advertisement Space -->
	<div id="pad_left">
		<table>
		<tr>
			<!-- video advertisements -->
			<th>
			<p>
				<video width = "470" height = "200" autoplay="autoplay" muted ="muted" >
			      <source src = "ad_Patagonia_Jacket.mp4">
			      <source src = "ad_Patagonia_Jacket.ogv"> 
			      <source src = "ad_Patagonia_Jacket.webm"> 
			      Your browser does not support the video element
		    	</video>
	    	</p>
	    	</th>

	    	<th>
			<p>
				<video width = "470" height = "200" autoplay="autoplay" muted ="muted" >
			      <source src = "ad_Patagonia_Jacket.mp4">
			      <source src = "ad_Patagonia_Jacket.ogv"> 
			      <source src = "ad_Patagonia_Jacket.webm"> 
			      Your browser does not support the video element
		    	</video>
	    	</p>
	    	</th>

	    	<th>
			<p>
				<video width = "470" height = "200" autoplay="autoplay" muted ="muted" >
			      <source src = "ad_Patagonia_Jacket.mp4">
			      <source src = "ad_Patagonia_Jacket.ogv"> 
			      <source src = "ad_Patagonia_Jacket.webm"> 
			      Your browser does not support the video element
		    	</video>
	    	</p>
	    	</th>
	    
	    </tr>
		</table>

	</div>


	<!-- new lines -->
	<br/><br/>
	<br/><br/>



	<!-- Pagination --> 
	<ul class="pagination fixed-bottom justify-content-center">
		<?php 
		if($current_page > 1) { 
		echo "<li class=\"page-item\"> <a class='page-link' href=\"?".$get_url."current_page=1\"> &lsaquo;&lsaquo; First </a> </li>";
		echo "<li class=\"page-item\"> <a class='page-link' href=\"?".$get_url."current_page=$previous_page\"> Previous </a> </li>"; } 
		?>

		<?php    
 		for ($counter = 1; $counter <= $num_page; $counter++) {
 			if ($counter == $current_page) {
 				echo "<li class='page-item active'><a class='page-link'>$counter</a></li>"; 
         	}
         	else {
        		echo "<li class='page-item'><a class='page-link' href='?".$get_url."current_page=$counter'>$counter</a></li>";
            }        
		} ?>
		
		<?php	  
		if($current_page < $num_page) { echo "<li class=\"page-item\"> <a class='page-link' href=\"?".$get_url."current_page=$next_page\"> Next </a> </li>"; } 
		?>
		 
		<?php if($current_page < $num_page){ echo "<li class=\"page-item\"><a class='page-link' href='?".$get_url."current_page=$num_page'>Last &rsaquo;&rsaquo;</a></li>"; } ?>
	</ul>


<?php
    require("footer.php");
?>
