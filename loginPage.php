
<!-- login page -->

<?php  
	require("header.php");
?>

	<p>
		<h3>Login Page</h3>
	</p>


	<p>
		<h4>Please enter the following information</h4>
	</p>


	<!-- The Form -->
	<form action="processLogin.php" method="post">
		<p>
			<label> User Name
				<input type="text" name="userName">
			</label>
		</p>


		<p>
			<label> Password
				<input type="text" name="password">
			</label>

			<br/>
		</p>


		<p class="description">
			A username can contain letters (both upper and lower case) and digits only. <br/>
			A password must be at least 6 characters long (characters are to be letters and digits only), <br/>
			have at least one letter and at least one digit
		</p>


		<p>
			<button type="submit">Submit</button>
		</p>

	</form>


<?php
    require("footer.php");
?>