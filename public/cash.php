<?php

    // configuration
    require("../includes/config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("cash_form.php", ["title" => "cash"]);
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty ($_POST["cash"]))
        {
            apologize ("Try again! Enter Cash");
        }
        else if (preg_match("/^\d+$/", $_POST["cash"]) != true)
        {
            apologize ("Please enter whole numbers.");
        }
        else
        {
            $cash = $_POST["cash"];
            //$userFund = CS50::query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
            //$updatedCash = $cash + $userFund[0]['cash'];
            if ($cash)
            {
                $update = CS50::query ("UPDATE users SET cash = cash + ? WHERE id = ?", $cash, $_SESSION["id"]);
                if ($update == false)
                {
                    apologize ("No cash Deposit.");
                }
                else
                {
                    redirect("/");
                }
            }
            
        }
        
        
    }
    
    
?>