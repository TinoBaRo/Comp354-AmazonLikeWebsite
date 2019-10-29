
<!-- processPostItem -->
<?php 
	// get session data
	session_start();

	require("header.php");
	echo "Writing to database the new item info ..."; 


	// results from the post item form
	$description = $_POST['description'];
	$category = $_POST['category'];
	$price = $_POST['price'];
	$quantity = $_POST['quantity'];
	$imageNameAndPath = $_POST['imageNameAndPath'];


	// write it to database: userName:description:category:price:quantity:imageNameAndPath
	$myfile = fopen("listedItemsData.txt", "a"); // "a" is mode append \\ "w" is mode write \\ "r" is mode read

	$text = $_SESSION['username'] . ":" . $description . ":" . $category . ":" . $price . ":" . $quantity . ":" . $imageNameAndPath . "\n";
	fwrite($myfile, $text);

	fclose($myfile);
?>