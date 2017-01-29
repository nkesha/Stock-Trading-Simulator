<?php

    // configuration
    require("../includes/config.php");
    
    $rows = CS50::query("SELECT symbol, shares FROM portfolios WHERE user_id = ?", $_SESSION["id"]);
    
    

    $positions = [];
    foreach ($rows as $row)
    {
        $stock = lookup ($row["symbol"]);
        if ($stock != false)
        {
            $positions[] = [
                "symbol" => $row["symbol"],
                "shares" => $row["shares"]
            ];     
           
        }
    }
    render("portfolio.php", ["title" =>"Portfolio", "positions" => $positions, "symbol"=> $positions, "shares"=>$positions]);   
?>
