<?php

	session_start();

	$item = $_SESSION['itemPage_id'];
	array_push($_SESSION['cart'], $item);

	//echo "<script type='text/javascript'>alert('$username');</script>";

	header("location: homePage.php");
?>