<?php
/**
 * This file deletes a record from the DB based on ?id=xxx in the URL and spits out
 * an error message, if there's no ID supplied. It uses the GET method to access the
 * data.
 * 
 * Made by Ondřej Augusta, hello@ondrejaugusta.cz, ondrejaugusta.cz
**/
    require_once "config.php";
    require_once "notification.php";
    
    session_start();
 
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    
    if(!isset($_GET['id'])) {
        echo "you haven't supplied the id i should delete are you making fun of me or what";
    } else {
        $id = $_GET['id'];
        $day = $_GET['day'];
        $query = "DELETE FROM lessons WHERE id=$id";
        mysqli_query($sql,$query) or die(mysqli_error());
        notification($_SESSION['username'],$day,"odebral/a hodinu");
        header("location: admin.php");
    }
?>