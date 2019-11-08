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
		  		<img src="images/logo354TheStars.png" height="50" width="110"> <!-- Logo Picture -->
		  	</a>
			
		<form method="GET" action="<?=$_SERVER['PHP_SELF'];?>">
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav mr-auto">
			    <li class="nav-item dropdown">
					<!--
			        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
			        Categories
			        </a>
			        <div class="dropdown-menu" aria-labelledby="navbarDropdown" name="filter">
			          <a class="dropdown-item" href="">Books</a>
			          <a class="dropdown-item" href="">Clothing</a>
					  <a class="dropdown-item" href="">Collectibles</a>
					  <a class="dropdown-item" href="">Electronics</a>
					  <a class="dropdown-item" href="">Fashion Accessories</a>
					  <a class="dropdown-item" href="">Hardware Supplies</a>
					  <a class="dropdown-item" href="">Health & Care</a>
					  <a class="dropdown-item" href="">Household Products</a>
					  <a class="dropdown-item" href="">Instruments</a>
					  <a class="dropdown-item" href="">Music</a>
					  <a class="dropdown-item" href="">Sports</a>
					  <a class="dropdown-item" href="">Toys</a>
					  <a class="dropdown-item" href="">Vehicles</a>
					  <a class="dropdown-item" href="">Video Games</a>
			        </div>
					-->
					<select name="filter">
						<option value="" selected disabled hidden>Categories</option>
						<option value="Books">Books</option>
						<option value="Clothing">Clothing</option>
						<option value="Collectibles">Collectibles</option>
						<option value="Electronics">Electronics</option>
						<option value="Fashion Accessories">Fashion Accessories</option>
						<option value="Hardware Supplies">Hardware Supplies</option>
						<option value="Health & Care">Health & Care</option>
						<option value="Household Products">Household Products</option>
						<option value="Instruments">Instruments</option>
						<option value="Music">Music</option>
						<option value="Sports">Sports</option>
						<option value="Toys">Toys</option>
						<option value="Vehicles">Vehicles</option>
						<option value="Video Games">Video Games</option>
					</select>
			    </li>  	
		    </ul>
    		
			<!-- search bar -->
			&nbsp;&nbsp;&nbsp;
			Search for:
			<input name="itemname" type="text" />
			&nbsp;&nbsp;&nbsp;
			Price Range
			$<input type="number" name="price_min" step="0.01" style="width: 75px;" ></input> -
			$<input type="number" name="price_max" step="0.01" style="width: 75px;" ></input>
			&nbsp;&nbsp;&nbsp;
			<input type="submit" value="Search" />
			
    		<!-- Important: show the name of the user name that is logged in (all the time, so must be on the header) -->
    		<!-- Conditions: showing Login and Signup buttons, or Logout button, depending on user logged in or not logged in -->
    		<?php  
			    error_reporting(0);
			
    			// brings the data from active session here, or starts a session with no data			
    			session_start();
				
    			if($_SESSION['username'] != null)
    			{
    				echo "Logged in as \"" . $_SESSION['username'] . "\" (" . $_SESSION['userid'] . ")";

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
		</form>

		</nav>


		<!-- Messages below the navigation bar -->
		<p>
			
		</p>
		
        
