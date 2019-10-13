<?php
error_reporting(0);
session_start();

$lmain = $_POST['lmain'];
$lindex = $_POST['lindex'];

$username = $_POST['username'];

//redirect user to home page if credentials are right

/*
if($login->isLoggedIn()) {
	//die ("Already have an account, no need to be on this page.");
}
else {
	print ("not logged in");

}
*/

$userid = 0;
$usertype = "";
$host = 'localhost';
$user = 'root';
$passwd = '';

$username_index = 1;
$email_index = 5;

//create that new account in DB once create account button clicked
if(isset($_POST['create_account'])) {
	//TODO: get a list of existing usernames and emails to ensure no username or email can be reused

	$register_successful = false;

	$username = $_POST['username'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$passwd = $_POST['password'];
	$email = $_POST['email'];
	$shipping = $_POST['street_address'];

    $users_table = fopen("database/users.txt", "a+");

	$lines = file("database/users.txt", FILE_IGNORE_NEW_LINES);
	print ("lines: -> ".$lines[count($lines) - 1].PHP_EOL);
	//print ("count: -> ".count($lines).PHP_EOL);
	$user_id = 1; //default user id value
	if (count($lines) > 0) {
		$datas = explode(":", $lines[count($lines) - 1]);
		print ("# datas: ".count($datas));
		print (" last id: ".$datas[0]." ".$datas[1]." ".$datas);
		$user_id = $datas[0] + 1; //increment id for each new user

		//make sure usernames and email adresses are unique:
		for ($i = 0; $i < count($lines); $i++) {
			$datas = explode(":", $lines[$i]);
			//check input username with every name in database
			if ($username == $datas[1]) {
				print ("username already taken!");
			}
			//check input email with every email in database
			else if ($email == $datas[5]) {
				print ("email address already taken!");
			}
			else {
				$register_successful = true;
			}
		}
	}

	if ($register_successful) {
		$data = $user_id.":".$username.":".$fname.":".$lname.":".$passwd.":".$email.":".$shipping.PHP_EOL;
		fwrite($users_table, $data);
		fclose($users_table);

		//notify user of successful registration

		//TODO: verification email

		//TODO: redirect user to index/main page after done registering
		/*
		ob_start();
		header('location: index.php');
		ob_end_flush();
		die();
		*/
	}
	else {
		print ("AAAAAAA");
	}
}
?>

<head>
  	<link rel="stylesheet" type="text/css" href="login.css">
	<title>354TheStars Registration</title>
</head>
  <body>
    <label>
		<form method="POST" action="<?=$_SERVER['PHP_SELF'];?>">
		<!--<img id="ima" src="pictures/logo.png">-->

		<table>
			<tr><h3>Register</h3></tr>
			<tr><td>Username</td><td> <input value="admin" type="text" name="username" required/></td></tr>
			<tr><td>First Name</td><td> <input value="Joshua" type="text" name="fname" required/></td>
			<td>Last Name</td><td> <input value="J" type="text" name="lname" required/></td></tr>
			<tr><td>Password</td><td> <input value="admin" type="password" name="password" required/></td></tr>
			<tr><td>Email Address</td><td> <input value="jacobsjjo@hotmail.com" type="text" name="email" required/></td></tr>
			<tr><td>Shipping Address</td><td> <input value="123 Fake Street" type="text" name="street_address" required/></td></tr>
   		</table>

 		<input type="hidden" name="userid" value="<?=$userid;?>" >
		<input type="hidden" name="usertype" value="<?=$usertype;?>" >
		<input type="hidden" name="token" value="<?=$token;?>" />
		<input type="hidden" name="lindex" value="<?=$lindex;?>" />
		<input type="submit" id="loginButton" name="create_account" value="Create Account" />

		</form>
  	</label>
</body>