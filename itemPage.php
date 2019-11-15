<!-- Item Page -->

<?php  
	require("header.php");
	include("computeRating.php");
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
						
					//look through users file for name of user who sold item
					$users = file("database/users.txt", FILE_IGNORE_NEW_LINES);
					$num_users = count($users);

					for ($i=0; $i < $num_users; $i++) { 
						$user = explode(':', $users[$i] );
						$userid_user = $user[0];
						if ($userid == $userid_user) {
							$seller = $user[1];
						}
					}

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
					
					$rating_stars = getRating($id);					
					if ($rating_stars > 0) { //if item has gotten reviews, rating_stars will have to be at least 1
						print ('<p class="card-body" style="font-size: 20px;">'.$rating_stars.' out of 5 stars <img src="images/star_full.jpg" style="width: 32px;"/></p>');
					}
					else { //if value 0 or NaN -> not yet initialized
						print ('<p class="card-body" style="font-size: 20px;">Not yet rated <img src="images/star_full.jpg" style="width: 32px;"/></p>');
					}
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
					<div class="card m-2 h-30">
							<h4> Price: </h4>
							<label>$<?php print ($price); ?></label>
							<h4> Seller: </h4>
							<label><?php print ($seller); ?></label>
							<h4><?php print ($stock); ?> in stock</h4>
					</div>
					

					<!-- Can purchase item, only if logged in -->
					<?php  
						if( isset($_SESSION['username']))
						{
							echo "
							<div class=\"m-2 h-30\">
								<form method=\"POST\" action=\"checkout.php\">
									<div class=\"btn-group\">									
										<input type=\"submit\" name=\"purchase\" class=\"btn btn-sm btn-outline-secondary\" value=\"Purchase Item\">
									</div>
								</form>
								<br />
								<h6>Leave a review!</h6>
								<form method=\"POST\" action=\"itemPage.php\">
									<div> <!--have all this stuff on one line -->
										<select name=\"rating\" style=\"width: 75px;\">
											<option value=\"\" selected disabled hidden>Stars</option>
											<option value=\"1\">1</option>
											<option value=\"2\">2</option>
											<option value=\"3\">3</option>
											<option value=\"4\">4</option>
											<option value=\"5\">5</option>
										</select>
										<img src=\"images/star_full.jpg\" style=\"width: 30px;\" />
										<input type=\"submit\" name=\"review\" value=\"Submit\" />
									</div>
									<h6>Write your review here (maximum 400 characters):</h6>
									<textarea name=\"review_text\" rows=\"8\" style=\"width: 100%;\"></textarea>
								</form>								
							</div>
							";
							//also grant ability to write reviews if logged in
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
	<?php
		//need to be logged in to review an item!
		if($_SESSION['username'] != null) {	
			$rating = $_POST["rating"];
			
			if(isset($_POST["review"]) && $rating != "") {	
				//review file is as follows--
				//ReviewID:ItemID:UserID:Stars:ReviewText
				$review_file = file("database/reviews.txt", FILE_IGNORE_NEW_LINES);
				//total number of reviews in system thus far
				$num_reviews = count($review_file);
				$next_id = 1;
				if ($num_reviews > 0) {
					$next_id = explode(":", $review_file[count($review_file) - 1])[0] + 1;
				}
				
				$stars = $rating;			
				$review_text = $_POST["review_text"];
				
				//make sure review is not too long
				if (strlen($review_text) > 400) {
					print ("Your review was ".(strlen($review_text) - 400).
						" characters longer than the maximum review length of 400 characters.");
				}
				else {
					$delimiter = ':';
				
					$new_review_line = 
						$next_id . $delimiter .
						$_SESSION["itemPage_id"] . $delimiter .
						$_SESSION["userid"] . $delimiter .
						$stars . $delimiter .
						$review_text.PHP_EOL;
						
					print ("Your review has been posted.");
					//write this line to items file
					$reviews_table = fopen("database/reviews.txt", "a+");
					fwrite($reviews_table, $new_review_line);
					fclose($reviews_table);
				}
			}
			else if (isset($_POST["review"]) && $rating == "") {			
				print ("You must specify a number of stars to review something.");
			}
		}
	?>
	<div class="card-body">
		<h4>Reviews for <?php print ($itemname); ?></h4>
		
	<?php
		//fetch all the reviews here
		$review_file = file("database/reviews.txt", FILE_IGNORE_NEW_LINES);
		$num_reviews = count($review_file);
		$itemid = $_SESSION["itemPage_id"];
		$found_review = false;
		
		for ($j = 0; $j < $num_reviews; $j++) {
			$datas = explode(":", $review_file[$j]); //split the line by colon		
			list($_, $itemid_FK, $_, $stars, $reviewText) = $datas;
			if ($itemid_FK === $itemid) {
				$found_review = true;
				//put the review
				print ('<h5>');
				for ($k = 0; $k < 5; $k++) { //for loop to display the visual for amount of stars
					if ($k >= $stars) {
						print ('<img src="images/star_empty.jpg" style="width: 20px;">');
					}
					else {
						print ('<img src="images/star_full.jpg" style="width: 20px;">');
					}
				}
				print(' | '.$stars.' out of 5 stars</h5>
				<p style="width: 50%">'.$reviewText.'</p>');
			}
		}
		if ($found_review == false) {
			print ('<p style="width: 50%">This item has not yet been reviewed.</p>');
		}
	?>
	</div>

<!-- don't need the other footer -->
 	</body>
</html>
