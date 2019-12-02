
<!-- index, initial landing page -->

<?php 
	require("header.php");
	include("computeRating.php");
	
	//unset($_SESSION["banner_index"]);
	
	if (!isset($_SESSION["banner_index"])) {
		$banner_index = 0;
	}
	else {
		$banner_index = $_SESSION["banner_index"];
	}
	print ($banner_index."<br />");

	$banner_items = array(
		"This is Best Sellers", 
		"This is Newest Items", 
		"This is Sponsored Items", 
		"This is Hottest Categories",
		"This is where you buy/give/redeem gift cards");
		
	$num_banner_items = count($banner_items);	

	if (isset($_POST["submit_prev"])) {		
		print ("Clicked previous button<br />");
		if ($banner_index > 0)	
			$_SESSION["banner_index"] -= 1;
		else
			$_SESSION["banner_index"] = $num_banner_items - 1;
	}
	if (isset($_POST["submit_next"])) {
		print ("Clicked next button<br />");
		if ($banner_index < ($num_banner_items - 1))
			$_SESSION["banner_index"] += 1;
		else	
			$_SESSION["banner_index"] = 0;
	}
	
	print ($banner_index."<br />");
?>
	<style>
	div#pad_left {
		padding-left: 20px;
	}
	
	div#landing_banner {
		height: 80px;
	}
	#button_left {
		float: left;
		padding-left: 20px;
	}
	#button_right {
		float: right;
		padding-right: 20px;
	}
	h3#center_ {		
		text-align: center;		
	}	
	input[type=submit]#banner_buttons {
		border: none;
		color: #EFEFEF;
		background-color: #282828;
		border-radius: 100%;
		width: 75px;
		height: 75px;
		font-size: 44px;
		font-style: oblique;
		padding-bottom: 75px;
	}
	
	</style>
	
	<div id="pad_left">
	<p>
		<h3>Index</h3>
	</p>
	</div>
	<br/>

	<main role="main">

	<div class="album py-5 bg-light">
	    <div id="landing_banner">
			<table>
				</tr>
					<td id="button_left"><form method="POST" action="index.php">
						<input type="submit" id="banner_buttons" name="submit_prev" value="<" />
					</form></td>
					<td style="width: 1500px;"><h3 id="center_">
						<?php echo $banner_items[$banner_index] ?>
					</h3></td>
					<td id="button_right"><form method="POST" action="index.php">
						<input type="submit" id="banner_buttons" name="submit_next" value=">" />
					</form></td>
				</tr>
			<table>
	    </div>
	</div>

	</main>

<?php
    require("footer.php");
?>
