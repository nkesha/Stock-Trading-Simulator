<?php
    //configuration
    require ("../includes/config.php");
    
    //if form was submitted.
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("quote_form.php", ["title" => "quote"]);
    }    
    
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty ($_POST["symbol"]))
        {
            apologize ("Try again! Wrong Symbol");
        }
        
        else 
        {
            $stock = lookup($_POST["symbol"]);
            if ($stock)
            {
                render("quote.php", ["price" => $stock["price"] ,"symbol" => $stock["symbol"]]);
            }
            else 
            {
                apologize ("Invalid Symbol");
            }

        }

    }
?>