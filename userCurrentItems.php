
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
			echo "<br> <img src=$srcc height=300 width=300/><br>$items[1]<br> $items[5]<br>$items[3] CAD<br>$items[8] left. </br>";

			echo "<hr>";
		}        
    }

   	echo "
   	<div>
        <br>
        <button class=\"btn btn-primary btn-lg \"> <a href=\"userprofilepage.php\"> </a> Back to user profile  </button>
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


