
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
			echo "<h2> Your Profile " . "\"" . $_SESSION['username'] . "\"" . "</h2>";
		?>

		<!-- default avatar photo -->
		<img src="userPhoto.png" height="200" width="200">

		<!-- dynamic information (has to be read from the database) -->
		<?php
			// read from database: firstName, lastName, address, email.
			$firstName;
			$lastName;
			$address;
			$email;

			// read and store
			$myfile = fopen("loginData.txt", "r"); // "a" is mode append \\ "w" is mode write \\ "r" is mode read
			$lineContents = file("loginData.txt"); // Each array element contains a line from the file
			$length = count($lineContents);
			fclose($myfile);

			// find the userName, then use its info
			// userName:password:firstName:lastName:address:email
			for ($i=0; $i < $length; $i++) 
			{ 
				$line = explode(':', $lineContents[$i] ); // iterates every line
				
				$userName = $line[0];
				$firstName = $line[2];
				$lastName = $line[3];
				$address = $line[4];
				$email = $line[5];

				// match the user that is currently in active session
				if (strcmp($userName, $_SESSION['username']) == 0) // found the user we were looking for
				{
					break;
				}
			}	

			// display user information
			echo "<h6> Full name: " . $firstName . " " . $lastName . "</h6>";
			echo "<h6> User address: " . $address . "</h6>";
			echo "<h6> User e-mail: " . $email . "</h6>";
		?>
	</div>

	</br>

	<!--Action Links -->
	<div>
		<a href="#">Purchased Items</a> </br></br>
		<a href="#">Current Listed Items</a> </br></br>
		
		<button> <a href="postItemPage.php">Post New Item</a>
		</button>
	</div>


</div> 






<!-- no need for the other footer -->
</body>
</html>

