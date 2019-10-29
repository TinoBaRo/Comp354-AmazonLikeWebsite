
<!-- postItemPage.php -->
<?php
	// get session data
	session_start();

	require("header.php");
?>

	<div class="py-5 text-center">
		<img src="logo354TheStars.png" height="200" width="300">
	    <h2>Post New Item</h2>
	    <h4>Enter the following information</h4>
	</div>

	<!-- The Form -->
	<form class="form-signin" action="processPostItem.php" method="post">
		
		<div class="mb-3">
			<label><strong>Description of the item</strong></label>
			<input class="form-control" type="text" name="description" required/>

			<label><strong>Select a Category</strong></label>
			<select class="form-control" name="category">
				  <option value="clothing">Clothing</option>
				  <option value="electronics">Electronics</option>
				  <option value="homeAndKitchen">Home and Kitchen</option>
				  <option value="electronics">Sports</option>
				  <option value="electronics">Entertainment</option>
			</select>

			<label><strong>Price</strong></label>
			<input class="form-control" type="text" name="price" required/>

			<label><strong>Quantity</strong></label>
			<input class="form-control" type="text" name="quantity" required/>

			<label><strong>Image (in local folder)</strong></label>
			<input class="form-control" type="text" name="imageNameAndPath" required/>

		</div>

		<button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>

	</form>



<!-- no need other footer for now -->
</body>
</html>

