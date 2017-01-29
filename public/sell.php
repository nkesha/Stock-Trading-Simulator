<?php
    //configuration
    require ("../includes/config.php");
    
        //if form was submitted.
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("sell_form.php", ["title" => "sell"]);
    }  
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty ($_POST["symbol"]))
        {
            apologize ("Try again! Wrong Symbol");
        }
        else 
        {
            $result = CS50::query("SELECT * FROM portfolios WHERE user_id = ? AND symbol = ?",$_SESSION["id"], $_POST["symbol"]);
            if ($result)
            {
        
                foreach ($result as $row)
                {
                    $shares = $row["shares"];
                    $stock = lookup ($_POST["symbol"]);
                    if ($stock)
                    {
                        $cash = $stock["price"] * $shares;
                        $delete = CS50::query ("DELETE FROM portfolios WHERE user_id = ? AND symbol = ?",$_SESSION["id"], $_POST["symbol"]);
                        if ($delete)
                        {
           
            
                            $historyList = CS50::query ("INSERT INTO history (action, symbol, shares, price) VALUES(?, ?, ?, ?)", "Sold", $_POST["symbol"], $shares, $stock["price"]);
                            $update = CS50::query ("UPDATE users SET cash = cash + ? WHERE id = ?", $cash, $_SESSION["id"]);
                            if ($update && $historyList)
                            {
                                redirect("/");
                                render ("sell.php", ["symbol" => $stock["symbol"]]);
                                
                            }
                            else
                            {
                                 apologize ("Share was not Sold . Please check your portfolio .");
                            }
                        }
                    }
                }
            }
            else
            {
                apologize ("Sorry not in your portfolio.");
            }
        }
    }
?>