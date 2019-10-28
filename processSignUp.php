
<!-- This file processes the Sign Up Form (from signUpPage.php), and then does an action --> 

<?php
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

	//Regular Expression for name and password
	$reg_name = "/^([a-z]|[A-Z]|[0-9])*([a-z]|[A-Z]|[0-9])$/";
	$reg_password = "/^([a-z]|[A-Z]|[0-9]){6,}$/";

	// holder variables we will use through the processing
	$userName = $_POST['userName'];
	$userPass = $_POST['password'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$address = $_POST['address'];
	$email = $_POST['email'];


	if( preg_match($reg_name, $userName) == true )
	{
		$correctName = true;
		//echo "True correctName";
	}

	if( preg_match($reg_password, $userPass) == true )
	{
		$correctPass = true;
		//echo "True correctPass";
	}

	// check if the user has already signed up before
	$loggedBefore = false;

	$myfile = fopen("loginData.txt", "r"); // "a" is mode append \\ "w" is mode write \\ "r" is mode read

	$lineContents = file("loginData.txt");

	$length = count($lineContents);

	fclose($myfile);

	//print_r($lineContents);

	$correctPassword = false; 
	
	// READ
	for ($i=0; $i < $length; $i++) 
	{ 
		$line = explode(':', $lineContents[$i] );

		$lineName = $line[0];

		$linePass = $line[1];


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
	if( ($correctName == true) && ($correctPass == true) && ($loggedBefore == false) )
	{
		//write to the file, welcome message, and Search
		echo "<div align=\"right\">";

		echo "<h4> Welcome " . $userName . "</h4>";

		echo "</div>";

		require("homePage.php");


		// write it to: myFile = loginData.txt
		$myfile = fopen("loginData.txt", "a"); // "a" is mode append \\ "w" is mode write \\ "r" is mode read

		$text = $userName . ":" . $userPass . ":" . $firstName . ":" . $lastName . ":" . $address . ":" . $email . "\n";

		fwrite($myfile, $text);

		fclose($myfile);
	}

	// if the user is found in the database (loggedBefore is true): the user name already exists
	if($loggedBefore == true)
	{
		unset($_SESSION);
		session_destroy();

		echo "<div>";

		echo "<h4> The user already exists, please log in or sign up with a different user name .</h4>";

		echo "</div>";

		require("signUpPage.php");
	}

?>
