
<?php  
	session_start();
?>

<!DOCTYPE html>
<!-- CREDIT TO BOOTSTRAP FOR GENERAL TEMPLATE -->

<body>

<link href="paypal.css" rel="stylesheet" type="text/css">

<div id="container">
	<form class="form-signin" action="ordercompleted.php">
	  <h1 class="h3 mb-3 font-weight-normal">Paypal</h1>
	  <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
	  <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
	  <div class="checkbox mb-3">
		<label>
		  <input type="checkbox" value="remember-me">Stay logged in to pay faster
		</label>
	  </div>
	  <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
	  <p class="mt-5 mb-3 text-muted">&copy; 2019</p>
	</form>
</div>


<!-- don't need the other footer -->
 	</body>
</html>