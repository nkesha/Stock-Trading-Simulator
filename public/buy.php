<?php

    require("../includes/config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("buy_form.php", ["title" => "buy"]);
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["symbol"]) || empty($_POST["shares"]))
        {
            apologize ("Wrong Output");
        }
        else if (preg_match("/^\d+$/", $_POST["shares"]) != true)
        {
            apologize ("Please enter whole numbers.");
        }
        else 
        {
            $stock = lookup ($_POST["symbol"]);
            if ($stock)
            {
                $cash = $stock["price"] * $_POST["shares"];
                $rows = CS50::query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
                if ($rows)
                {
                    foreach ($rows as $row)
                    {
                        $cashUser = $row["cash"];
                    }
                    if ($cash > $cashUser)
                    {
                        apologize ("No sufficient fund !");
                    }
                    else
                    {
                        
                        $symbol = strtoupper($stock["symbol"]);
                        $update = CS50::query ("UPDATE users SET cash = cash - ? WHERE id = ?", $cash, $_SESSION["id"]);
                        $insert = CS50::query ("INSERT INTO portfolios (user_id, symbol, shares) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE shares = shares + VALUES (shares)", $_SESSION["id"], $symbol, $_POST["shares"]);
                        $historyList = CS50::query ("INSERT INTO history (action, symbol, shares, price) VALUES(?, ?, ?, ?)", "Bought", $_POST["symbol"], $_POST["shares"], $stock["price"]);
                        redirect("/");
                    }
                }
            }
        }
    }
                  
?>