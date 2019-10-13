<?php
error_reporting(0);
session_start();

$lmain = $_POST['lmain'];
$lindex = $_POST['lindex'];

if(isset($_POST['login']))
{
	$login = new Login();

	$username = $_POST['username'];

	//redirect user to home page if credentials are right
	if($login->isLoggedIn()) {
		header('location: index.php');
	}
  	else {
    	$login->showErrors();
  	}
}

$userid = 0;
$usertype = "";
$host = 'localhost';
$user = 'root';
$passwd = '';

//search to see if that person exists in DB

$rs = $mysqli->query($_data);

if (mysqli_num_rows($rs) === 0) {
	print ("");
}
else if ($rs) {
 while ($row = $rs->fetch_assoc())
	{
		$_SESSION['userid'] = $row["userid"];
		$_SESSION['usertype'] = $row["usertype"];
		$_SESSION['firstname'] = $row["firstname"];
		$_SESSION['lastname'] = $row["lastname"];
		$_SESSION['address'] = $row["address"];
 	}
}

$token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));

print ("successful login");
?>


<head>
  	<link rel="stylesheet" type="text/css" href="login.css">
	<title>Log In</title>
</head>
  <body>
    <label>
		<form method="POST" action="<?=$_SERVER['PHP_SELF'];?>">
		<img id="ima" src="pictures/logo.png">

		<table>
			<tr><h3>Sign in</h3></tr>
			<tr><td>Username:</td><td> <input type="text" name="username" required/></td></tr>
			<tr><td>Password:</td><td> <input type="password" name="password" required/></td></tr>
   		</table>

 		<input type="hidden" name="userid" value="<?=$userid;?>" >
		<input type="hidden" name="usertype" value="<?=$usertype;?>" >
		<input type="hidden" name="token" value="<?=$token;?>" />
		<input type="hidden" name="lindex" value="<?=$lindex;?>" />
		<input type="submit" id="loginButton" name="login" value="Log in" />

		</form>
  	</label>
</body>