
<!-- This file processes the Sign Up Form (from signUpPage.php), and then does an action --> 

<?php
	error_reporting(0);

	$min_pass_length = 6;
	
	// start a session when someone Signs up
	// also initialize 2 session variables: username and password
	//session_unset();
	//session_destroy();

	session_start();
	// STORE SESSION DATA
	$_SESSION['username'] = $_POST['userName']; 
	$_SESSION['password'] = $_POST['password'];

	$_SESSION['firstName'] = $_POST['firstName'];
	$_SESSION['lastName'] = $_POST['lastName'];
	$_SESSION['address'] = $_POST['address'];
	$_SESSION['email'] = $_POST['email'];

	// holder variables we will use through the processing
	$userName = $_POST['userName'];
	$userPass = $_POST['password'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$address = $_POST['address'];
	$email = $_POST['email'];

	// check if the user has already signed up before
	$loggedBefore = false;

	$myfile = fopen("loginData.txt", "r"); // "a" is mode append \\ "w" is mode write \\ "r" is mode read

	$lineContents = file("loginData.txt");

	$length = count($lineContents);

	fclose($myfile);

	//print_r($lineContents);

	// READ
	for ($i=0; $i < $length; $i++) 
	{ 
		$line = explode(':', $lineContents[$i] );

		$lineName = $line[1];
		$linePass = $line[2];

		// userName is matched: the user has been here before
		if( strcmp($userName, $lineName) == 0 )
		{
			// echo "The user has logged in before.";
			$loggedBefore = true;
		}
	}

	// SIGN-UP CASE
	// The user has NEVER logged in before
	// he is not in the file
	// he will be written into the file
	if($loggedBefore == false)
	{
		$pass_long_enough = false;
		$pass_has_letter = false;
		$pass_has_digit  = false;
		
		if (strlen($userPass) >= $min_pass_length) {
			$pass_long_enough = true;
		}
		
		//make sure pass has >= 1 letter and >= 1 digit
		for ($i = 0; $i < strlen($userPass); $i++) {
			if ($pass_has_letter === false && ctype_alpha($userPass[$i])) {
				$pass_has_letter = true;
			}
			if ($pass_has_digit === false && ctype_digit($userPass[$i])) {
				$pass_has_digit = true;
			}
		}
		
		if ($pass_long_enough === false || $pass_has_letter === false || $pass_has_digit === false) {
			//prompt new user password doesn't meet requirements
			if ($pass_long_enough === false) {
				$_SESSION['signUpErrorMsg'] .= "Password must contain at least ".$min_pass_length." characters.<br />";
				echo "<div>";
				echo "<h4> Password must contain at least ".$min_pass_length." characters.";
				echo "</div>";
			}
			if ($pass_has_letter === false) {
				$_SESSION['signUpErrorMsg'] .= "Password must contain at least 1 letter.<br />";
				echo "<div>";
				echo "<h4> Password must contain at least 1 letter.";
				echo "</div>";
			}
			if ($pass_has_digit === false) {
				$_SESSION['signUpErrorMsg'] .= "Password must contain at least 1 number.<br />";
				echo "<div>";
				echo "<h4> Password must contain at least 1 number.";
				echo "</div>";
			}
			
			//unset this data if failing to register
			unset($_SESSION['username']);
			unset($_SESSION['password']);
			unset($_SESSION['firstName']);
			unset($_SESSION['lastName']);
			unset($_SESSION['address']);
			unset($_SESSION['email']);
			
			require("signUpPage.php");
		}
		else {			
			//write to the file, welcome message, and Search
			echo "<div align=\"right\">";
			echo "<h4> Welcome " . $userName . "</h4>";
			echo "</div>";

			require("homePage.php");

			// write it to: myFile = loginData.txt
			$myfile = fopen("loginData.txt", "a"); // "a" is mode append \\ "w" is mode write \\ "r" is mode read
			$text = ($length) . ":" . $userName . ":" . $userPass . ":" . $firstName . ":" . $lastName . ":" . $address . ":" . $email . PHP_EOL;
			fwrite($myfile, $text);
			fclose($myfile);			
		}
	}

	// if the user is found in the database (loggedBefore is true): the user name already exists
	if($loggedBefore == true)
	{
		unset($_SESSION);
		session_destroy();

		echo "<div>";

		echo "<h4> Username already exists, please log in or sign up with a different username .</h4>";

		echo "</div>";

		require("signUpPage.php");
	}

?>
