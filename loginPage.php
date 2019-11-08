
<!-- login page -->

<?php  
	require("header.php");
?>

	<div class="py-5 text-center">
        <h2>Login</h2>
        <h4>If you are a returning user, please log in.</h4>
        <h4>Otherwise, sign up first.</h4>
    </div>


	<!-- The Form -->
	<form class="form-signin" action="processLogin.php" method="post">
		
		<div class="mb-3">
			<label><strong>Username</strong></label>
			<input class="form-control" type="text" name="userName" required/>

			<label><strong>Password</strong></label>
			<input class="form-control" type="password" name="password" required/>
   		</div>

		<button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>

	</form>


<!-- don't need the other footer to browse between pages -->
</body>
</html>