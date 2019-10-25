<?php
session_start();
error_reporting(0);

$userid_index   = 0;
$username_index = 1;
$fname_index    = 2;
$lname_index    = 3;
$password_index = 4;

$invalid_msg = "Invalid username or password.";

if(isset($_POST['login'])) {
	$username = $_POST['username'];
	$passwd = $_POST['password'];
	
	$userid = 0;
	$usertype = '';
	$host = 'localhost';
	$user = 'root';
	$passwd = '';

	//search to see if that person exists in DB
	print ("logging ".$username." in...");

	$users = file("database/users.txt", FILE_IGNORE_NEW_LINES);
	for ($i = 0; $i < count($users); $i++) {
		print ($users[$i]);
		$datas = explode(":", $users[$i].PHP_EOL);
		print ($username." == ".$datas[$username_index]."?");
		if ($username == $datas[$username_index]) {
			//we found the user in the DB
			$userid = $datas[$userid_index];
			print ("user found!");
			//then check if passwords match up
			if ($username == $datas[$password_index]) {
				print (" login successful!!");
				
				ob_start();
				//session_start();
				
				//create session and set session data
				$_SESSION['userid'] = $datas[$userid_index];
				$_SESSION['username'] = $datas[$username_index];
				$_SESSION['firstname'] = $datas[$fname_index];
				$_SESSION['lastname'] = $datas[$lname_index];				
				//$token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));
				
				//redirect to home page
				//ob_start();
				header('location: index.php');
				//ob_end_flush();
				//die();
			}
		}
		else {
			print ($invalid_msg);
		}
	}
}


?>

<head>
  	<link rel="stylesheet" type="text/css" href="login.css">
	<title>Log In</title>
</head>
  <body>
    <label>
		<form method="POST" action="<?=$_SERVER['PHP_SELF'];?>">
		<!--<img id="ima" src="pictures/logo.png">-->

		<table>
			<tr><h3>Sign in</h3></tr>
			<tr><td>Username:</td><td> <input type="text" value="admin" name="username" required/></td></tr>
			<tr><td>Password:</td><td> <input type="password" 
			value="admin" name="password" required/></td></tr>
			<!--<tr><td>Password:</td><td> <input type="password" 
			value="password" name="password" required/></td></tr>-->
   		</table>

 		<input type="hidden" name="userid" value="<?=$userid;?>" >
		<input type="hidden" name="usertype" value="<?=$usertype;?>" >
		<input type="hidden" name="token" value="<?=$token;?>" />
		<input type="hidden" name="lindex" value="<?=$lindex;?>" />
		<input type="submit" id="loginButton" name="login" value="Log in" />

		</form>
  	</label>
</body>