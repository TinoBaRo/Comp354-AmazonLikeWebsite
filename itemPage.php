<!-- Item Page -->

<?php  
	require("header.php");
?>
		<div class="card m-2 bg-light">
			
			<!-- row -->
			<div class="row">
				<!-- Item Pic -->
				<div class="col-md-5">

				<?php
					//lookup
					$lines = file("database/items.txt", FILE_IGNORE_NEW_LINES);
					$num_items = count($lines);
					$match = null;

					for ($i = 0; $i < $num_items; $i++) 
					{
						$datas = explode(":", $lines[$i]); //split the line by colon		
						
						list($id, $_, $_, 
							$_, $_, $_, $_, 
							$_, $_, $_) = $datas;
								
						if ($id == $_SESSION["itemPage_id"]) 
						{
							$match = $lines[$i];
						}
					}
					
					list($id, $itemname, $_, 
						$price, $userid, $description_short, $description_long, 
						$category, $stock, $return_policy) = explode(":", $match);
				
					print ('<img src="images/'.$id.'.jpg" class="img-fluid">');
				?>

				</div>

				<!-- Item description-->
				<div class="card-body col-md-4">
					<div class="row">
						<h1><?php print ($itemname); ?></h1>
					</div>	
					<div class="row">
						<small><?php print ($category); ?></small>
					</div>	
					<br/>

					<div class="row">
						<p><?php print ($description_short); ?></p>
					</div>
					<div class="row">
						<p><?php print ($description_long); ?></p>
					</div>
				</div>

				<div class="col-md-3">
					<div class="card m-2 h-50">
							<h4> Price: </h4>
							<label>$<?php print ($price); ?></label>
							<h4><?php print ($stock); ?> in stock</h4>
					</div>


					<div class="m-2 h-50">
						<form method="" action="">
							<div class="btn-group">									
								<input type="submit" name="purchase" class="btn btn-sm btn-outline-secondary" value="Purchase Item">
							</div>
						</form>
					</div>
				</div>



			</div>

		</div>


<!-- don't need the other footer -->
 	</body>
</html>
