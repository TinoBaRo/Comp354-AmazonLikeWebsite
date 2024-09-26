<?php

	session_start();

	$item = $_GET['remove'];
	unset($_SESSION['cart'][$item]); //remove item from cart

	$_SESSION['cart'] = array_values($_SESSION['cart']); // rebase array


	header("location: shoppingCartPage.php");
?>