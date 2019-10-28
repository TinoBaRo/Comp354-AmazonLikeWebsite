<!DOCTYPE html>

<html>
	

	<head>
		<title>354 The Stars</title>

		<!-- Bootstrap css ***needs to go before other css files*** -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		<link rel="stylesheet" type="text/css" href="generalStyle.css">
		<link rel="stylesheet" type="text/css" href="albumLayout.css">
		
		<meta charset="utf-8">

		<script type="text/javascript" src="someJavaScriptFile.js"> 
		</script>

	</head>


	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  	
		  	<a class="navbar-brand" href="homePage.php">
		  		<img src="logo354TheStars.png" height="50" width="110"> <!-- Logo Picture -->
		  	</a>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav mr-auto">
			    <li class="nav-item dropdown">
			        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
			        Categories
			        </a>
			        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			          <a class="dropdown-item" href="#">Category 1</a>
			          <a class="dropdown-item" href="#">Category 2</a>
			        </div>
			    </li>  	
		    </ul>
    		
    		<!-- Important: show the name of the user name that is logged in (all the time, so must be on the header) -->
    		<!-- Conditions: showing Login and Signup buttons, or Logout button, depending on user logged in or not logged in -->
    		<?php  
    			// brings the data from active session here, or starts a session with no data
    			session_start();

    			if($_SESSION['username'] != null)
    			{
    				echo "Logged in as \"" . $_SESSION['username'] . "\"";

    				// if logged in, user will be able to logout
    				echo "<form class=\"form-inline my-2 my-lg-0\">
							<a class=\"nav-link\" href=\"processLogout.php\">Logout</a>
	  						</form> ";

	  				// if logged in, user will be able to go to his/her profile page
	  				echo "<form class=\"form-inline my-2 my-lg-0\">
							<a class=\"nav-link\" href=\"userProfilePage.php\">User Profile</a>
	  						</form> ";
    			}
    			else
    			{
    				echo "<form class=\"form-inline my-2 my-lg-0\">
	  	 	 				<a class=\"nav-link\" href=\"loginPage.php\">Login</a>
	    	 				<a class=\"nav-link\" href=\"signUpPage.php\">Sign up</a>
			    			</form>";
    			}
			    
		    ?>

		</div>

		</nav>


		<!-- Messages below the navigation bar -->
		<p>
			
		</p>
		
        
