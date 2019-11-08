<!-- Item Page -->

<?php  
	require("header.php");
    session_start();
?>
   
        <div class="card">

          <div class="card-block">
            
            <div class="mx-auto" style="width: 200px;">
              
            <img class="card-img-top" src="logo354TheStars.png" alt="Card image cap">
            <div class="card-block">  
            </div>
            <h4 class="card-title">Checkout</h4>
            <h6 class="card-subtitle mb-4 text-muted">Review</h6>
            <p class="card-text">
                <?php
                session_start();
                echo $_SESSION["Item1_name"];
                ?> 
            </p>

            <ul class="list-group list-group-flush">

            <li class="list-group-item">Item price:
                <H1>
                    <?php
                    session_start();
                    echo $_SESSION["Item1_price"];
                    ?> 
                </H1>
            </li>
            
            <li class="list-group-item">State taxes:
                <H1>
                    <?php
                        echo "8%";
                    ?> 
                </H1>
            </li>

            <li class="list-group-item">Delivery Fee:
                <H1>
                    <?php
                echo "$3.99";
                ?> 
                </H1>
            </li>
           
            <li class="list-group-item">Total: </li>
            </ul>

            <a href="paypal.html" class="card-link">Place Order</a>
            <a href="homePage.php" class="card-link">Cancel</a>
            <a href="paypal.html" class="btn btn-primary" role="button" >One  time purchase</a>
        
            </div>
            </div>
            </div>		
            </div>    
              
                </div>
			</div>
		</div>


<!-- don't need the other footer -->
 	</body>
</html>
