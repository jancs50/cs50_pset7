<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }
    // if form was submitted
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission, check username
        if (empty($_POST["username"]))
        {
            apologize("Please provide your username.");
        }
        // check if password is filled
        else if (empty($_POST["password"]))
        {
            apologize("Please provide your password.");
        }
        // check if confirmation password is filled
        else if (empty($_POST["confirmation"]))
        {
            apologize("Please provide confirmation of password.");
        }
        // check if password and confirmation match
        else if (($_POST["password"]) !== ($_POST["confirmation"]))
        {
            apologize("Passwords do not match.");
        }
    }
  
    // if checks sanity are ok, proceed with insertion 
    if (query("INSERT INTO users (username, hash, cash) VALUES(?, ?, 10000.00)", $_POST["username"], crypt($_POST["password"])) === false)
    {
        apologize("Username not available");
    }
    else
    {
        // get user id
        $rows = query("SELECT LAST_INSERT_ID() AS id");
        $id = $rows[0]["id"];

        // remember that user's now logged in by storing user's ID in session
        $_SESSION["id"] = $row["id"];

        redirect("/");
    }
?>
