<?php  
	require("header.php");
?>


<h2><span style="padding-left:20px;">Your order has been completed.</span></h2>
		<?php  
			
			if(isset($_SESSION['username'])){
				echo "<h3><span style=\"padding-left:20px;\">Thanks, " . $_SESSION['username'] . ", for shopping at 354TheStars.com! Come back soon</span></h3><br>";
			}
			else{
				echo "<h3><span style=\"padding-left:20px;\">Thanks for shopping at 354TheStars.com! Come back soon</span></h3><br>";
			}
		?>
		


<?php
    require("footer.php");
?>