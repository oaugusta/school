<?php
/**
 * This file provides the edit function of this project. It simply updates
 * the data in the DB. If there is no URL set during the edit, it will spit
 * out "nothing set mate" as an error message. Since I got really lazy,
 * I set it up to only check one field, not all of them.
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
    
    $https = "https://";
    $http = "http://";
    $base_url = $_POST["url"];
    if($_POST["url"] !== "") {
        if (strpos($_POST['url'],$https) !== false or strpos($_POST['url'],$http) !== false) {
            $url = $base_url;
        } else {
            $url = $https . $base_url;
        }
    }
        
        
        $day = $_POST['day'];
        $time = $_POST['time'];
        $s1 = $_POST['s1'];
        $s2 = $_POST['s2'];
        $a1 = $_POST['a1'];
        $a2 = $_POST['a2'];
        $inf1 = $_POST['inf1'];
        $inf2 = $_POST['inf2'];
        $id = $_GET['id'];
        $ledit = date("d.m.") . " v " . date("H:i");
        $query="UPDATE lessons SET url = '$url', day = $day, time = '$time', lastedit = '$ledit', s1 = $s1, s2 = $s2, a1 = $a1, a2 = $a2, inf1 = $inf1, inf2 = $inf2 WHERE id=$id";


mysqli_query($sql,$query) or die(mysqli_error());
notification($_SESSION['username'],$day,"upravil/a hodinu");
header("location: admin.php");
?>