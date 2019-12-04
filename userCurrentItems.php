
<!-- userCurrentItems -->
<?php 
	// get session data
	session_start();

	require("header.php");
?>


<div class="py-5 text-center">
	<img src="logo354TheStars.png" height="200" width="300">
    <h2>Listed Items</h2>

</div>


<?php 
	// read from database: userName:description:category:price:quantity:imageNameAndPath
	$myfile = fopen("database/items.txt", "r"); // "a" is mode append \\ "w" is mode write \\ "r" is mode read
    

	echo "
	<div class=\"card\">
	    <div class=\"card-block\">
	        <div class=\"mx-auto\" style=\"width: 600px;\">
    ";

    while(!feof($myfile)) 
    {
		$items = explode (":", fgets($myfile));
		if ($items[4] == $_SESSION['userid']) 
		{
			$srcc = "images/$items[2]";
			echo "<br> <img src=$srcc height=300 width=300/>
				<form method='POST' action='userCurrentItems.php'>
					<input type='submit' name='sponsor' value='Sponsor Item' id='$itemid'>
					<input type='hidden' name='sponsor' value='$items[0]:$items[1]:$items[3]'/>
				</form>
				<br>$items[1]<br> $items[5]<br>$items[3] CAD<br>$items[8] left. </br>";

			echo "<hr>";
		}        
    }

   	echo "
   	<div>
        <br>
         <a href=\"userProfilePage.php\"> <button class=\"btn btn-primary btn-lg \"> Back to user profile </button> </a>  
        <br>
        <br>
        <br>
	</div>
   	";

    echo "
			</div>
	    </div>
    </div>
    "; 

	fclose($myfile);
	
	if (isset($_POST['sponsor'])) {
		$passed_data = $_POST['sponsor'];
		
		$item_attributes = explode(":", $passed_data);
		
		$id = $item_attributes[0];
		$name = $item_attributes[1];
		$price = $item_attributes[2];
		
		$_SESSION['sponsorItem']['itemId'] = $id;
		$_SESSION['sponsorItem']['itemName'] = $name;
		$_SESSION['sponsorItem']['itemPrice'] = $price;
		
		print ("<script>location.href='sponsorItem.php';</script>"); //redirect to sponsorItem.php
	}
?>


