<!-- userCurrentItems -->
<?php 
	// get session data
	session_start();

	require("header.php");


	// read from database: userName:description:category:price:quantity:imageNameAndPath
	$myfile = fopen("listedItemsData.txt", "r"); // "a" is mode append \\ "w" is mode write \\ "r" is mode read
        
        while(!feof($myfile)) {
        $items = explode (":", fgets($myfile));
        if ($items[0] == $_SESSION['username']){
        $srcc = "listedImagesFolder/$items[5]";
        echo "<br><img src=$srcc height=300 width=300/><br>$items[1], $items[2], $items[3] CAD, $items[4] left.</br>";
        }
        
        }

	fclose($myfile);
?>

<div>
        <br>
        <button><a href="userprofilepage.php">Back to user profile</a></button>
</div>