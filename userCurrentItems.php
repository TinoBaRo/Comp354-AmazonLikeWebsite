<!-- userCurrentItems -->
<?php 
	// get session data
	session_start();
        require("header.php");


        // read from database: id:name:image:price:userid:shortdescription:longdescription:category:quantity:refund
	$myfile = fopen("database\items.txt", "r"); // "a" is mode append \\ "w" is mode write \\ "r" is mode read
        
        while(!feof($myfile)) {
        $items = explode (":", fgets($myfile));
        if ($items[4] == $_SESSION['userid']){
        $srcc = "images/$items[2]";
        echo "<br><img src=$srcc height=300 width=300/><br>$items[1]<br> $items[5]<br>$items[3] CAD<br>$items[8] left.</br>";
        }
        
        }

	fclose($myfile);
	


	
?>

<div>
        <br>
        <button><a href="userprofilepage.php">Back to user profile</a></button>
</div>