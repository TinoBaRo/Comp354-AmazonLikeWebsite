
<?php  
	require("header.php");

	session_start();
?>

<div class="card">
    <div class="card-block">
        <div class="mx-auto" style="width: 600px;">
              
                <img class="card-img-top" src="logo354TheStars.png" alt="Card image cap">

                <?php  
					if(isset($_SESSION['username']))
					{
						echo "<h4> Your order has been completed \"" . $_SESSION['username'] . "\". </h4>";
						echo "<br/>";
						echo "<h4> Thanks for shopping at 354TheStars.com! </h4>";
						echo "<br/>";
						echo "<h4> Come back soon </h4>";
					}
					else
					{
						echo "<h4> Your order has been completed. Thanks for shopping at 354TheStars.com! </h4>";
						echo "<br/>";
						echo "<h4> Thanks for shopping at 354TheStars.com! </h4>";
						echo "<br/>";
						echo "<h4> Come back soon </h4>";
					}
				?>
        </div>
    </div>
</div>


<?php  
	// UPDATE 'itemst.txt' database since the user went through PAYPAL
	// ...

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
				
		if ($id == $_SESSION["itemPage_id"]) 
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
?>


<!-- don't need the other footer -->
 	</body>
</html>
