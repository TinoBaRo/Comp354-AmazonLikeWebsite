
<!-- password recovery -->

<?php  
	require("header.php");
?>

	<div class="py-5 text-center">
        <h2>Password Recovery</h2>
    </div>


	<!-- Form  #1 -->
	<form class="form-signin" action="passwordRecoveryEnterNewPass.php" method="post">
		
		<div class="mb-3">
			<label><strong>Enter Your E-mail</strong></label>
			<input class="form-control" type="email" name="email" required/>

			
   		</div>

		<button class="btn btn-primary btn-lg btn-block" type="submit">Request Confirmation Code</button>
	</form>




<!-- don't need the other footer to browse between pages -->
</body>
</html>
