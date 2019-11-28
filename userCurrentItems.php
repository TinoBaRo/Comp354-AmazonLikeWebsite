
<!-- userCurrentItems -->
<?php 
	// get session data
	session_start();

	require("header.php");
?>


<?php 
	// read from database: userName:description:category:price:quantity:imageNameAndPath
	$myfile = fopen("database/items.txt", "r"); // "a" is mode append \\ "w" is mode write \\ "r" is mode read
    
	echo "<h4>These are your Listed Items: </h4> </br>";

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
			echo "<br> <img src=$srcc height=300 width=300/><br>$items[1]<br> $items[5]<br>$items[3] CAD<br>$items[8] left. </br>";

			echo "<hr>";
		}        
    }

   	echo "
   	<div>
        <br>
        <button><a href=\"userprofilepage.php\">Back to user profile</a></button>
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
?>


