
<!-- This file processes the login Form (from loginPage.php), and then does an action --> 

<?php
	// start a session when someone logs in
	// also initialize 2 session variables: username and password
	session_unset();
	session_destroy();

	session_start();
	$_SESSION['username'] = $_POST['userName']; 
	$_SESSION['password'] = $_POST['password'];


	//
	$reg_name = "/^([a-z]|[A-Z]|[0-9])*([a-z]|[A-Z]|[0-9])$/";
	$reg_password = "/^([a-z]|[A-Z]|[0-9]){6,}$/";


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

		$lineName = $line[0];

		$linePass = $line[1];


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
				//echo "Set $correctPassword to true";
			}

			// we found the logged value
			break;
		}
	}

	// if the user logged in before and the password is INCORRECT
	// make the user try again to enter the correct password
	if( ($loggedBefore == true) && ($correctPassword == false) )
	{
		echo "<h4> The user logged in before, but the password is incorrect. </h4>";

		echo " <h4> Please, try entering the correct password again. </h4>";
		
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

		require("homePage.php");
	}

	// if the user has never been here before: he needs to sign up first or enter the correct username
	if($loggedBefore == false)
	{
		unset($_SESSION);
		session_destroy();
		
		echo "<div align=\"right\">";

		echo "The user name does not exist. Please enter the right user name or sign up.";

		echo "</div>";

		require("loginPage.php");
	}


?>
