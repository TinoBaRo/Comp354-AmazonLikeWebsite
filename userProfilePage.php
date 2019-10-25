
<!-- User Profile Page -->
<?php
	// get session data
	session_start();

	require("header.php");
?>


<!-- User information and some links -->
<div class="py-3 text-center">
	<!-- user information and picture -->
	<div>
		<?php  
			// Show user name profile
			echo "<h2> Your Profile " . "\"" .$_SESSION['username'] . "\"" . "</h2>";
		?>

		<!-- default avatar photo -->
		<img src="userPhoto.png" height="200" width="200">

		<!-- dynamic information -->
		<?php
			// display other information
			echo "<h6>" . "User email: ..." .  "</h6>";
			echo "<h6>" . "User address: ..." .  "</h6>";
		?>
	</div>

	</br>

	<!--Action Links -->
	<div>
		<a href="#">Purchased Items</a> </br></br>
		<a href="#">Current Listed Items</a> </br></br>
		
		<button> <a href="#">Post New Item</a>
		</button>
	</div>


</div>






<!-- no need for the other footer -->
</body>
</html>

