
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



	// ---- CASE 1 ---- if the user has already logged in before
	// if the user enters the incorrect password, make him try again.
	// if he enters the correct password, redirect him to the search page
	$loggedBefore = false;

	$myfile = fopen("loginData.txt", "r"); // "a" is mode append \\ "w" is mode write \\ "r" is mode read

	$lineContents = file("loginData.txt");

	$length = count($lineContents);

	fclose($myfile);

	//print_r($lineContents);

	$correctPassword = false; 
	
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
	// redirect him to to the Search page
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
	


	// ---- CASE 2 ---- if the user has NEVER logged in before
	// he is not in the file
	// he will be written into the file
	if( ($correctName == true) && ($correctPass == true) && ($loggedBefore == false) )
	{
		//write to the file, welcome message, and Search
		echo "<div align=\"right\">";

		echo "<h4> Welcome " . $userName . "</h4>";

		echo "</div>";

		require("homePage.php");


		// write it to: myFile = loginFile.txt
		$myfile = fopen("loginData.txt", "a"); // "a" is mode append \\ "w" is mode write \\ "r" is mode read

		$text = $userName . ":" . $userPass . "\n";

		fwrite($myfile, $text);

		fclose($myfile);
	}

?>