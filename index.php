
<!-- index, initial landing page -->

	<style>
	input#banner_link {
		border: none;
		color: #007bff;
		text-decoration: underline;
		background-color: rgba(0,0,0,0);
	}
	
	input#banner_link_bold {
		border: none;
		color: #007bff;
		text-decoration: underline;
		font-weight: bold;
		background-color: rgba(0,0,0,0);
	}
	</style>

<?php 
	require("header.php");
	include("computeRating.php");
	include("bannerItems.php");

	$index_cookie = file("cookies/index_banner.txt", FILE_IGNORE_NEW_LINES);
	$banner_index = $index_cookie[0];

	$banner_items = array(
		'<form method="GET" action="homePage.php">
			<input type="submit" id="banner_link" name="best_sellers" value="'.$banner_strings[0].'" />
		</form>',
		'<form method="GET" action="homePage.php">
			<input type="submit" id="banner_link" name="new_items" value="'.$banner_strings[1].'" />
		</form>',
		'<form method="GET" action="homePage.php">
			<input type="submit" id="banner_link" name="best_categories" value="'.$banner_strings[2].'" />
		</form>');
		
	$num_banner_items = count($banner_items);

	if (isset($_POST["submit_prev"])) {		
		if ($banner_index > 0) {
			//$_SESSION["banner_index"] -= 1;
			$banner_index -= 1;
		}
		else {
			//$_SESSION["banner_index"] = $num_banner_items - 1;
			$banner_index = $num_banner_items - 1;
		}
		$new_index = fopen("cookies/index_banner.txt", "w");
		fwrite($new_index, $banner_index);
		fclose($new_index);
	}
	if (isset($_POST["submit_next"])) {
		if ($banner_index < ($num_banner_items - 1)) {
			$_SESSION["banner_index"] += 1;
			$banner_index += 1;
		}
		else {
			$_SESSION["banner_index"] = 0;
			$banner_index = 0;
		}
		$new_index = fopen("cookies/index_banner.txt", "w");
		fwrite($new_index, $banner_index);
		fclose($new_index);
	}
?>
	<style>
	#pad_left {
		padding-left: 20px;
	}
	
	div#landing_banner {
		height: 80px;
	}
	#button_left {
		float: left;
		padding-left: 20px;
	}
	#button_right {
		float: right;
		padding-right: 20px;
	}
	h3#center_ {		
		text-align: center;		
	}	
	input[type=submit]#banner_buttons {
		border: none;
		color: #EFEFEF;
		background-color: #282828;
		border-radius: 100%;
		width: 75px;
		height: 75px;
		font-size: 44px;
		font-style: oblique;
		padding-bottom: 75px;
	}
	
	</style>
	
	<div id="pad_left">
	<p>
		<h3>Index</h3>
	</p>
	</div>
	<br/>

	<main role="main">

	<div class="album py-5 bg-light">
	    <div id="landing_banner">
			<table>
				</tr>
					<td id="button_left"><form method="POST" action="index.php">
						<input type="submit" id="banner_buttons" name="submit_prev" value="<" />
					</form></td>
					<td style="width: 1500px;"><h3 id="center_">
						<?php echo $banner_items[$banner_index] ?>
					</h3></td>
					<td id="button_right"><form method="POST" action="index.php">
						<input type="submit" id="banner_buttons" name="submit_next" value=">" />
					</form></td>
				</tr>
			<table>
	    </div>
	</div>

<?php
	//special means of filtering, activated from index page
	//view order history by retrieving orders data, orders.txt file
	$order_lines = file("database/orders.txt", FILE_IGNORE_NEW_LINES);
	$num_orders = count($order_lines);
				
	//items.txt file
	$item_lines = file("database/items.txt", FILE_IGNORE_NEW_LINES);
	$num_items = count($lines);

	function popular_items_for_category($input_category, $order_lines, $num_orders) {
		$item_ids = array();
		for ($i = 0; $i < $num_orders; $i++) {
			$order_datas = explode(":", $order_lines[$i]); //split the line by colon		
			list($_, $_, $id, $_, $category, $_) = $order_datas;

			//item has to be in the requested category...
			if ($category == $input_category) {
				array_push($item_ids, $id);
			}
		}
		
		//get the most commonly occurring category out of this array...
		$counts = array_count_values($item_ids);
		arsort($counts);
		//best sellers: people whose items were bought the most; 2: get top 2 selling items
		$best_ids = array_slice(array_keys($counts), 0, 2, true);
		
		return $best_ids;
	}
	
	function display_items_index($items_ids, $item_lines, $num_items) {
		print ('<table id="pad_left"><tr id="pad_left">');
		for ($i = 0; $i < count($items_ids); $i++) {
			$curr_id = $items_ids[$i];
			$item_datas = explode(":", $item_lines[$curr_id - 1]); //split the line by colon

			list($itemid, $itemname, $_, 
				$price, $userid_fk, $_, $_, 
				$_, $_, $_) = $item_datas;
			
			print 
				('<td id="pad_left" style="width: 250px";>
					<div class="card-body">
						<form method="POST" action="index.php">
							<input type="submit" id="banner_link_bold" name="viewItem" value="'.$itemname.'" />
							<input type="hidden" name="id" value="'.$itemid.'" />
						</form>
					</div>
						<img src="images/'.$curr_id.'.jpg" width="100" height="100">
					</form>
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center">
						<p class="card-text" style="text-align: right;">$'.$price.'</p>
					</div>					
				</div>
				</td>'); 
		}
		print ('</tr></table>');
	}
	
	function display_category($cat_name, $order_lines, $num_orders, $item_lines, $num_items) {
		$cat_data = popular_items_for_category($cat_name, $order_lines, $num_orders);
		
		if (count($cat_data) > 0) {
			echo "<h4>Most Popular Items in $cat_name</h4>";
			display_items_index($cat_data, $item_lines, $num_items);
			echo "<hr />";
		}		
	}
?>
	<div id="pad_left">
	<br />
	<hr />
	<p>
		<?php	
		display_category("Books", $order_lines, $num_orders, $item_lines, $num_items);
		display_category("Electronics", $order_lines, $num_orders, $item_lines, $num_items);
		display_category("Clothing", $order_lines, $num_orders, $item_lines, $num_items);
		display_category("Video Games", $order_lines, $num_orders, $item_lines, $num_items);
		display_category("Toys", $order_lines, $num_orders, $item_lines, $num_items);
		?>
		
	</p>
	</div>
	
	</main>

<?php
	if (isset($_POST['id'])) {
		$_SESSION["itemPage_id"] = $_POST['id'];
		print ("<script>location.href='itemPage.php';</script>"); //redirect to itemPage.php
	}

    require("footer.php");
?>
