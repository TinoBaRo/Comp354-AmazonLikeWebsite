<!-- Sponsor Page -->
<!-- 
Landing page for user who wishes to sponsor/gain priority advertising of item.
Displays how much user pays through PayPal to get the sponsored status on their item.
Sponsored items will appear on the front page frequently, and will have a 'sponsored'
label/mark of verification next to them.
-->

<?php  
	require("header.php");
    session_start();
?>
   
    <div class="card">
        <div class="card-block">
            <div class="mx-auto" style="width: 200px;">
              
                <img class="card-img-top" src="logo354TheStars.png" alt="Card image cap">
                
                <h2 class="card-title">Sponsor Item</h2>

                <ul class="list-group list-group-flush">

                    <li class="list-group-item"> Item name:
                        <h5>
                            <?php
                                echo $_SESSION['sponsorItem']['itemName'];
                            ?>
                        <h5> 
                    </li>

                    <li class="list-group-item"> Sponsorship fee:
                        <h5>
                            <?php
								//one-time sponsorship fee = 20% of item price
                                $fee = ($_SESSION['sponsorItem']['itemPrice'] * 20 / 100);
								echo "$".number_format($fee, 2, '.', '');
                            ?> 
                        </h5>
                    </li>
                </ul>

                <?php
					echo 
					"<div>
						<a href=\"paypal.php\" class=\"btn btn-primary\" role=\"button\">Sponsor Item</a>
						<br/>
						<br/>
						<a href=\"homePage.php\" class=\"btn btn-primary\" role=\"button\">Cancel</a>
					</div>
					";  
                ?>

            </div>
		</div>
	</div>

    <!-- fix ugly space missing... -->
    <br/>
    <br/>
    <br/>

<!-- don't need the other footer -->
 	</body>
</html>
