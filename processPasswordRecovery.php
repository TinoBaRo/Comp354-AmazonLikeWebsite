
<!-- This file processes the login Form (from loginPage.php), and then does an action --> 

<?php
	include("salt.php");
	error_reporting(0);

	// this is the information I got for the password recovery
	//session_start();
	//$_SESSION['username'] = $_POST['username']; 
	//$_SESSION['newPassword'] = $_POST['newPassword'];
	//$_SESSION['cart'] = array(); //initialize cart as an empty array

	// holder variables we will use for the processing
	$userName = $_POST['username'];
	$newPass = $_POST['newPassword'];
	

	// Logic:
	// If the user has already logged in before, he will be able to modify his password with the 'newPassword'
	// 1. check if the user has already signed up before
	// 2. get all his information
	// 3. write new password
	// 4. end session
	$loggedBefore = false;
	$changedPassword = false;

	$myfile = fopen("database/loginData.txt", "r"); // "a" is mode append \\ "w" is mode write \\ "r" is mode read

	$lineContents = file("database/loginData.txt");
	$length = count($lineContents);

	fclose($myfile);

	// READ
	for ($i=0; $i < $length; $i++) 
	{ 
		$line = explode(':', $lineContents[$i] );

		$lineUsername = $line[1];

		// userName is matched: the user has been here before
		if( strcmp($userName, $lineUsername) == 0 )
		{
			// echo "The user has logged in before.";
			$loggedBefore = true;

			$matchLine = $lineContents[$i];

			// get all user's data, that will be re-written with the 'newPassword'
			$lineId = $line[0];
			$lineFirstName = $line[3];
			$lineLastName = $line[4];
			$lineAddress = $line[5];
			$lineEmail = $line[6];

			// newPassword
			$newPassword = crypt($newPass, '$2y$07$'.$salt.'$');

			$newLine = $lineId .":". $lineUsername .":". $newPassword .":". $lineFirstName .":". $lineLastName .":". $lineAddress .":". $lineEmail;

			// WRITE new line, with the user's new password
			//read the entire string
			$str=file_get_contents('database/loginData.txt');

			//replace something in the file string - this is a VERY simple example
			$str=str_replace($matchLine, $newLine, $str);

			//write the entire string
			file_put_contents('database/loginData.txt', $str);

			$changedPassword = true;
		}
	}

?>



<!-- RESULT -->
<?php  
	require("header.php");
?>

<div class="card">
    <div class="card-block">
    	<div class="mx-auto" style="width: 400px;">

        <img class="card-img-top" src="images\logo.png" alt="Card image cap">
        <br>
        <br>

<?php  

	if ($changedPassword == true)
	{
		echo "<h4> Your password has been succesfully changed \"" . $userName  . "\". </h4>";
		echo "<br/>";
		echo " <a href=\"homePage.php\"> <button class=\"btn btn-primary btn-lg\"> Return Home </button> </a>  ";
	}
	else
	{
		echo "<h4> Could not reset your password. </h4>";
		echo "<br/>";
		echo "<h4> User \"" . $userName  . "\" does not exist. </h4>";
		echo "<br/>";
		echo " <a href=\"homePage.php\"> <button class=\"btn btn-primary btn-lg\"> Return Home </button> </a>  ";
	}

?>

 		</div>
    </div>
</div>


<!-- don't need the other footer -->
 	</body>
</html>

