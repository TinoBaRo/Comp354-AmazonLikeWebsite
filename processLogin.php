
<!-- This file processes the login Form (from loginPage.php), and then does an action --> 

<?php
	error_reporting(0);

	// start a session when someone logs in
	// also initialize 2 session variables: username and password
	//session_unset();
	//session_destroy();

	session_start();
	$_SESSION['username'] = $_POST['userName']; 
	$_SESSION['password'] = $_POST['password'];


	// Regular expression for username and password
	$reg_name = "/^([a-z]|[A-Z]|[0-9])*([a-z]|[A-Z]|[0-9])$/";
	$reg_password = "/^([a-z]|[A-Z]|[0-9]){6,}$/";


	// holder variables we will use for the processing
	$userName = $_POST['userName'];
	$userPass = $_POST['password'];

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


	// LOGIN CASES
	// Check that the user has already signed up before, then:
	// if the user enters the incorrect password, make him try again.
	// if he enters the correct password, redirect him to the Home page
	// if the user enters a non existing user, tell him to sign-up or enter the correct user name (NEED TO DO THIS)
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

		$lineId = $line[0];
		$lineName = $line[1];
		$linePass = $line[2];

		// userName is matched: the user has been here before
		if( strcmp($userName, $lineName) == 0 )
		{
			// echo "The user has logged in before.";
			$loggedBefore = true;

			// deal with password
			$lineName = trim($lineName);
			$linePass = trim($linePass);

			if( strcmp($userPass, $linePass) == 0 )
			{
				$correctPassword = true;
				$_SESSION['userid'] = $lineId; // <- user's id also sent to session var
			}

			// we found the logged value
			break;
		}
	}

	// if the user logged in before and the password is INCORRECT
	// make the user try again to enter the correct password
	if( ($loggedBefore == true) && ($correctPassword == false) )
	{
		unset($_SESSION);
		session_destroy();
		
		echo "<h4> The user logged in before, but the password is incorrect. </h4>";

		echo "<h4> Enter password again. </h4>";
		
		//echo $userPass . " didn't match " . $linePass;

		require("loginPage.php");
	}

	// if the user logged in before and the password is CORRECT
	// redirect him to to the Home page
	// ALSO, REMOVE THE SIGN-IN, LOG-IN BUTTONS AND PUT LOGOUT!!!
	if( ($loggedBefore == true) && ($correctPassword == true) )
	{
		// welcome message, and Search (NOT WRITE TO FILE, since he is already saved in file)
		echo "<div align=\"right\">";

		echo "Correct Password";
		echo "<br/>";
		echo "<h4> Welcome " . $userName . "</h4>";

		echo "</div>";

		//require("homePage.php");
		header("location: homePage.php");
	}

	// if the user has never been here before: he needs to sign up first or enter the correct username
	if($loggedBefore == false)
	{
		unset($_SESSION);
		session_destroy();

		//echo "<div align=\"right\">";
		echo "<h4>Username does not exist. Enter the correct username or sign up.</h4>";

		//echo "The user name does not exist. Please enter the right user name or sign up.";

		//echo "</div>";

		require("loginPage.php");
	}


?>
