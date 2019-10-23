
<!-- login page -->

<?php  
	require("header.php");
?>

	<div class="py-5 text-center">
        <h2>Login</h2>
        <h4>Please enter the following information</h4>
    </div>


	<!-- The Form -->
	<form class="form-signin" action="processLogin.php" method="post">
		
		<div class="mb-3">
			<label><strong>Username</strong></label>
			<input class="form-control" type="text" name="userName" required/>

			<label><strong>Password</strong></label>
			<input class="form-control" type="password" name="password" required/>
   		</div>

		<p class="description"><small>
			A username can contain letters (both upper and lower case) and digits only. <br/>
			A password must be at least 6 characters long (characters are to be letters and digits only), <br/>
			have at least one letter and at least one digit
		</small></p>


		<button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>

	</form>


<?php
    require("footer.php");
?>