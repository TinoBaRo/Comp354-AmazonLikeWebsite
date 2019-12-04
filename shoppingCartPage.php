
<!-- login page -->

<?php  
	require("header.php");
?>

<?php 
	if (count($_SESSION['cart']) == 0) {
		echo "<h4 style=\"padding-left:12px;\">Your cart is empty</h4>";
	}

	else {
		$count = 1; // count of items in cart
		$total_price = 0; // total price
		echo "	<div class=\"card m-2 bg-light\">

					<div class=\"card-header\"><h4>My Shopping Cart</h4></div>
						<div class=\"card-body\">
							<table class=\"table table-striped table-bordered\">
				  				<thead>
								    <tr>
								      <th scope=\"col\" style=\"width: 5%\">#</th>
								      <th scope=\"col\" style=\"width: 45%\">Name</th>
								      <th scope=\"col\" style=\"width: 10%\">Quantity</th>
								      <th scope=\"col\" style=\"width: 25%\">Price</th>
								      <th scope=\"col\" style=\"width: 15%\">Remove from Cart</th>
								    </tr>
								</thead>
								<tbody>
					    ";
					    
		foreach ($_SESSION['cart'] as $value) {

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
						
				if ($id == $value) 
				{
					// Initializing: $match
					$match = $lines[$i];
				}
			}
			
			list($id, $itemname, $itemimage, 
				$price, $userid, $description_short, $description_long, 
				$category, $stock, $return_policy) = explode(":", $match);


			echo "<tr>
				      <th scope=\"row\">" . $count . "</th>
				      <td>" . $itemname . "</td>
				      <td>" . 1 . "</td>
				      <td>" . $price . "</td>
				      <td class=\"text-center\"><a href=\"removeFromShoppingCart.php?remove=" . ($count - 1) . "\"  class=\"btn btn-danger\"> Remove </a></td>
			      </tr>";

			$count++;
			$total_price += $price;
		}

		$taxes = $total_price * 0.08;
		$total = $total_price + $taxes + 3.99;

		echo "			<tr>
						    <th scope=\"row\"></th>
						    <td></td>
						    <td></td>
						    <td class=\"text-right\"><b>Price Before Taxes</b></td>
						    <td class=\"text-center\"><b> $" . number_format($total_price,2,'.','') . "</b></td>
				        </tr>
				        <tr>
						    <th scope=\"row\"></th>
						    <td></td>
						    <td></td>
						    <td class=\"text-right\"><b>State Taxes</b></td>
						    <td class=\"text-center\"><b> $" . number_format($taxes,2,'.','') . "</b></td>
				        </tr>
				        <tr>
						    <th scope=\"row\"></th>
						    <td></td>
						    <td></td>
						    <td class=\"text-right\"><b>Delivery Fee</b></td>
						    <td class=\"text-center\"><b> $3.99</b></td>
				        </tr>
				        <tr>
						    <th scope=\"row\"></th>
						    <td></td>
						    <td></td>
						    <td class=\"text-right\"><b>Final Total</b></td>
						    <td class=\"text-center\"><b> $" . number_format($total,2,'.','') . "</b></td>
				        </tr>
						</tbody>
					</table>
					<form method=\"POST\" action=\"paypal.php\" class=\"text-right\">
						<label>Payment is only accepted by PayPal</label>
						<br />
						<div class=\"btn-group\">									
							<input type=\"submit\" name=\"purchase\" class=\"btn btn-sm btn-outline-primary\" value=\"Proceed to Checkout\">
						</div>
					</form>
				</div>
			</div>";
		
	}

?>


<!-- don't need the other footer to browse between pages -->
</body>
</html>