
<!-- password recovery -->

<?php  
	require("header.php");

	session_start();
?>

	<div class="py-5 text-center">
        <h2>Password Recovery</h2>
    </div>


	<!-- Form 2 -->
	<form class="form-signin" action="processPasswordRecovery.php" method="post">
		
		<div class="mb-3">
			<!-- WE AREN'T SENDING AN EMAIL, SO ANY CODE WILL WORK -->
			<label><strong>Enter the confirmation code received in your email: <?php echo $_POST['email']; ?>   </strong></label>
			<input class="form-control" type="text" name="confirmationCode" required/>

			<label><strong>Enter Your Username </strong></label>
			<input class="form-control" type="text" name="username" required/>

			<label><strong>Enter New Password</strong></label>
			<input class="form-control" type="password" name="newPassword" required/>
   		</div>

		<button class="btn btn-primary btn-lg btn-block" type="submit">Set New Password</button>
	</form>


<!-- don't need the other footer to browse between pages -->
</body>
</html>
