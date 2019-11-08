

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Checks Whether a File Exists or Not in PHP</title>
</head>

<body>


<?php
   
session_start();
    // parsing item data base per tab
    $file = "listedItemsData.txt";
    // Check the existence of file
    if(file_exists($file))
    {
        echo "The file $file exists." . "<br>";
        
        // Attempt to open the file
        $handle = fopen($file, "r") or die("ERROR: Cannot open the file.");
        
        if($handle)
        {
            echo "Success.";
            
            // Closing the file handle
            fclose($handle);
        }
    } 
    else
    {
        echo "ERROR: Failure.";
    }

    $productsArray = file("listedItemsData.txt", FILE_IGNORE_NEW_LINES);
    
    foreach ($productsArray as $key => &$product) 
    {
       $arr = explode("\t", $product);
       $product = array("reference" => $arr[0], "name" => $arr[1], "price" => $arr[2]);

    }

    $_SESSION["Item1_price"] = $productsArray[0] ["price"];
    $_SESSION["Item2_price"] = $productsArray[1] ["price"];
    $_SESSION["Item3_price"] = $productsArray[2] ["price"];
    $_SESSION["Item1_name"] = $productsArray[0] ["name"] ;
    $_SESSION["Item2_name"] = $productsArray[1] ["name"] ;
    $_SESSION["Item3_name"] = $productsArray[2] ["name"] ;
   
?>

</body>
</html>
