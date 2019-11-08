<!-- Item Page -->

<?php  
	require("header.php");
	session_start();
?>
		<div class="card m-2 bg-light">
			
			<!-- row -->
			<div class="row">
				<!-- Item Pic -->
				<div class="col-md-5">

				<?php
					//lookup
					//getting data from the database
					$lines = file("database/items.txt", FILE_IGNORE_NEW_LINES);
					$num_items = count($lines);
					$match = null;

					for ($i = 0; $i < $num_items; $i++) 
					{
						// itemID:itemName:index.jpg:price:userID:shortDescrip:longDescription:category:numberInStock:returnPolicy
						$datas = explode(":", $lines[$i]); //split the line by colon		
						
						// assign array values to variables: interested in $id
						list($id, $_, $_, 
							$_, $_, $_, $_, 
							$_, $_, $_) = $datas;
								
						if ($id == $_SESSION["itemPage_id"]) 
						{
							// Initializing: $match
							$match = $lines[$i];
						}
					}
					
					list($id, $itemname, $itemimage, 
						$price, $userid, $description_short, $description_long, 
						$category, $stock, $return_policy) = explode(":", $match);


					// STORE ITEM: gonna start with assuming only 1 item...
					// itemID:itemName:index.jpg:price:userID:shortDescrip:longDescription:category:numberInStock:returnPolicy
					// 1:Mario Hat:1.jpg:14.99:1:Hat that Mario wears:LongDescription:Clothing:3:none
					$_SESSION['checkoutItem']['itemId'] = $id;
					$_SESSION['checkoutItem']['itemName'] = $itemname;
					$_SESSION['checkoutItem']['itemImage'] = $itemimage;
					$_SESSION['checkoutItem']['itemPrice'] = $price;
					$_SESSION['checkoutItem']['userId'] = $userid;
					$_SESSION['checkoutItem']['shortDescription'] = $description_short;
					$_SESSION['checkoutItem']['longDescription'] = $description_long;
					$_SESSION['checkoutItem']['category'] = $category;
					$_SESSION['checkoutItem']['numberStock'] = $stock;
					$_SESSION['checkoutItem']['returnPolicy'] = $return_policy;


					print ('<img src="images/'.$id.'.jpg" class="img-fluid">');
				?>

				</div>

				<!-- Item description-->
				<div class="card-body col-md-4">
					<div class="row">
						<h1><?php print ($itemname); ?></h1>
					</div>	
					<div class="row">
						<small><?php print ($category); ?></small>
					</div>	
					<br/>

					<div class="row">
						<p><?php print ($description_short); ?></p>
					</div>
					<div class="row">
						<p><?php print ($description_long); ?></p>
					</div>
				</div>

				<div class="col-md-3">
					<div class="card m-2 h-50">
							<h4> Price: </h4>
							<label>$<?php print ($price); ?></label>
							<h4><?php print ($stock); ?> in stock</h4>
					</div>

					<!-- Can purchase item, only if logged in -->
					<?php  
						if( isset($_SESSION['username']))
						{
							echo "
							<div class=\"m-2 h-50\">
								<form method=\"POST\" action=\"checkout.php\">
									<div class=\"btn-group\">									
										<input type=\"submit\" name=\"purchase\" class=\"btn btn-sm btn-outline-secondary\" value=\"Purchase Item\">
									</div>
								</form>
							</div>
							";
						}
						else
							echo "
							<div class=\"m-2 h-50\">
								<h5>
								To purchase the item, you must be logged in.
								</h5>
							</div>
						";
					?>
					

				</div>


			</div>

		</div>


<!-- don't need the other footer -->
 	</body>
</html>
