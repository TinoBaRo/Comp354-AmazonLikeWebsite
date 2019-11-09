<!-- Item Page -->

<?php  
	require("header.php");
    session_start();
?>
   
    <div class="card">
        <div class="card-block">
            <div class="mx-auto" style="width: 200px;">
              
                <img class="card-img-top" src="logo354TheStars.png" alt="Card image cap">
                
                <h2 class="card-title">Checkout</h2>

                <ul class="list-group list-group-flush">

                    <li class="list-group-item"> Item name:
                        <h5>
                            <?php
                                echo $_SESSION['checkoutItem']['itemName'];
                            ?>
                        <h5> 
                    </li>

                    <li class="list-group-item"> Quantity left:
                        <h5>
                            <?php
                                echo $_SESSION['checkoutItem']['numberStock'];
                            ?>
                        <h5> 
                    </li>


                    <li class="list-group-item"> Item price:
                        <h5>
                            <?php
                                echo  $_SESSION['checkoutItem']['itemPrice'];
                            ?> 
                        </h5>
                    </li>
                    
                    <li class="list-group-item">State taxes:
                        <h5>
                            <?php
                                echo "8%";
                            ?> 
                        </h5>
                    </li>

                    <li class="list-group-item">Delivery Fee:
                        <h5>
                            <?php
                                echo "$3.99";
                            ?> 
                        </h5>
                    </li>
                   
                    <li class="list-group-item">Total:
                        <h5>
                            <?php
                                $total = (($_SESSION['checkoutItem']['itemPrice']*8)/100) + ($_SESSION['checkoutItem']['itemPrice']) + 3.99;
                                echo $total;
                            ?> 
                        </h5>
                    </li>
                </ul>

                <?php
                    if ($_SESSION['checkoutItem']['numberStock'] <= 0) 
                    {
                    
                        echo "<h5>The item is out of stock. Sorry for the inconvenience</h5> 
                        <br/>
                        <a href=\"homePage.php\" class=\"card-link\">Return Home</a>
                        ";
                        
                    }
                    else 
                    {
                        echo "<h5>In stock</h5>
                        <div>
                            <a href=\"paypal.php\" class=\"btn btn-primary\" role=\"button\">Purchase Item</a>
                            <br/>
                            <br/>
                            <a href=\"homePage.php\" class=\"btn btn-primary\" role=\"button\">Cancel</a>
                        </div>
                        ";
                    }    
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
