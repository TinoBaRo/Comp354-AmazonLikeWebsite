
<!-- userCurrentItems -->
<?php 
	// get session data
	session_start();

	require("header.php");
?>


<div class="py-5 text-center">
	<img src="images\logo.png" height="300" width="400">
    <br>
    <br>
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
    $gotAnItem = false;
    while(!feof($myfile)) 
    {
		$items = explode (":", fgets($myfile));
		if ($items[4] == $_SESSION['userid']) 
		{
                        if($items[3]==null){
                        break;}
                        $gotAnItem = true;
			$srcc = "images/$items[2]";
			echo "<br> <img src=$srcc height=300 width=300/><br>$items[1]<br> $items[5]<br>$items[3] CAD<br>$items[8] left. </br>";

			echo "<hr>";
		}        
    }
    if ($gotAnItem == false){
    echo "<br>You currently have no posted items";
    }

   	echo "
   	<div>
        <br>
         <a href=\"userProfilePage.php\"> <button class=\"btn btn-primary btn-lg \"> Back to user profile </button> </a>  
         <a href=\"postItemPage.php\"> <button class=\"btn btn-primary btn-lg \"> Post New Item for Sale </button> </a>
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


