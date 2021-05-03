<?php

/**
 * This script deletes a file from a folder and prevents
 * users to delete a file, if it doesn't belong to them.
**/
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$name = $_GET["n"];
echo $name;
$username = $_SESSION["username"];
echo $username;
if(strpos($name, $username) === false) {
    $_SESSION["errormsg"] = "Nemůžete odstranit soubor někoho jiného!";
    header("location: up.php");
} else{
    $del = unlink("uploads/" . $name);
    if ($del === false) {
        $_SESSION["errormsg"] = "Nepodařilo se odstranit soubor.";
        header("location: up.php");
    } else {
        $_SESSION["successmsg"] = "Úspěšně odstraněno!";
        header("location: up.php");
    }
}