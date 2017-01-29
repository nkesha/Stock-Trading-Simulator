<?php
    
    //configuration
    require ("../includes/config.php");
    
    //if user reached page via GET (as by clicking a link or via direct)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("register_form.php", ["title" => "Register"]);
    }
    
    //else if user reached from page via POST (as submit a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty ($_POST["username"]) || empty ($_POST["password"]) 
            || ($_POST["confirmation"] != $_POST["password"]))
        {
                apologize("Incomplete submission. Please try again !");
        }
        else 
        {
            $result = CS50::query("INSERT IGNORE INTO users (username, hash, cash) VALUES(?, ?, 10000.0000)", $_POST["username"], password_hash($_POST["password"], PASSWORD_DEFAULT));
            
            if ($result != false)
            {
                $rows = CS50::query("SELECT LAST_INSERT_ID() AS id");
                $id = $rows[0]["id"];
                
                
                $_SESSION["id"] = $id;
                
                redirect ("index.php");
            }
            else
            {
                apologize("ERROR !!");
            }
            
        }
        
    }
?>