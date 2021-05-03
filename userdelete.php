<?php

/**
 * Script that deletes a user.
 * Hand-crafted
 * 
 * </> O. Augusta, hello@ondrejaugusta.cz, ondrejaugusta.cz
**/

session_start();
require_once "config.php";
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
if(!isset($_GET['id'])) {
    echo 'ID not set, stop fooling me!';
} else {
    $id = $_GET["id"]; //assign ID from URL to a variable
    $q = "DELETE FROM users WHERE id=" . $id; //prepare a db query
    mysqli_query($sql,$q); //exec the q
    header("location: users.php"); //return back
}
?>