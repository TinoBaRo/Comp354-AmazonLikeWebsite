<?php  
	session_start();
	// UPDATE 'items.txt' database since the user went through PAYPAL
	// ...

	foreach ($_SESSION['cart'] as $value) {

		// READ
		$lines = file("database/items.txt", FILE_IGNORE_NEW_LINES);

		$num_items = count($lines);
		$matchLine = null;

		for ($i = 0; $i < $num_items; $i++) 
		{
			// itemID:itemName:index.jpg:price:userID:shortDescrip:longDescription:category:numberInStock:returnPolicy
			$datas = explode(":", $lines[$i]); //split the line by colon		
			
			// assign array values to variables: interested in $id
			list($id, $_, $_, 
				$_, $_, $_, $_, 
				$_, $_, $_) = $datas;
					
			if ($id == $value) 
			{
				// Initializing: $matchLine
				$matchLine = $lines[$i];
			}
		}

		list($id, $itemname, $itemimage, 
			$price, $userid, $description_short, $description_long, 
			$category, $stock, $return_policy) = explode(":", $matchLine);


		// REPLACE OLD VALUE in $stock 
		$newStock = ($stock - 1);
		
		$newLine = $id .":". $itemname .":". $itemimage .":". $price .":". $userid .":". $description_short .":". $description_long .":". $category .":". $newStock .":". $return_policy;


		// WRITE
		//read the entire string
		$str=file_get_contents('database/items.txt');

		//replace something in the file string - this is a VERY simple example
		$str=str_replace($matchLine, $newLine,$str);

		//write the entire string
		file_put_contents('database/items.txt', $str);
	}

	// after updating database, unset shopping cart
	$_SESSION['cart'] = array();

?>

<?php  
	require("header.php");
?>

<div class="card">
    <div class="card-block">
        <div class="mx-auto" style="width: 400px;">
              
                <img class="card-img-top" src="images\logo.png" alt="Card image cap">
                <br>
    			<br>

                <?php  
					if(isset($_SESSION['username']) and isset($_SESSION['checkoutItem']))
					{
						//order file is as follows--
						//OrderID(PK):UserID(Seller,FK):ItemID(FK):ItemName:ItemCategory:OrderDate
						$order_file = file("database/orders.txt", FILE_IGNORE_NEW_LINES);
						//total number of orders in system thus far
						$num_orders = count($order_file);
						$next_id = 1;
						if ($num_orders > 0) {
							$next_id = explode(":", $order_file[count($order_file) - 1])[0] + 1;
						}
						
						$delimiter = ':';
				
						$new_order_line = 
						$next_id . $delimiter .
							$_SESSION['checkoutItem']['userId'] . $delimiter .
							$_SESSION['checkoutItem']['itemId'] . $delimiter .
							$_SESSION['checkoutItem']['itemName'] . $delimiter .
							$_SESSION['checkoutItem']['category'] . $delimiter .
						date("Y-m-d") . $review_text.PHP_EOL;

						//write this line to orders file
						$orders_table = fopen("database/orders.txt", "a+");
						fwrite($orders_table, $new_order_line);
						fclose($orders_table);
						
						echo "<h4> Your order has been completed \"" . $_SESSION['username'] . "\". </h4>";
						echo "<br/>";
						echo "<h4> Thanks for shopping at 354TheStars.com! </h4>";
						echo "<br/>";
						echo "<h4> Come back soon.</h4>";
					}
					else
					{
						echo "<h4> Whoops! Something went wrong. </h4>";
						echo "<a href='homePage.php'> Back to home page </h4>";
					}
				?>
        </div>
    </div>
</div>





<!-- don't need the other footer -->
 	</body>
</html>
