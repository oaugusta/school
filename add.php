<?php
/**
 * This PHP file adds a record into the DB with data supplied
 * in the admin panel.
 * It also checks for https:// contained in the link, if it's
 * not present, this script will add it by itself.
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
    $base_url = $_POST['url'];
    
    if (isset($_POST['name']) && isset($_POST['day']) && isset($_POST['time'])){
        if ($base_url !== "") {
            if (strpos($_POST['url'],$https) !== false) {
                $url = $base_url;
            } else {
                $url = $https . $base_url;
            }
        }
        $name = $_POST['name'];
        $day = $_POST['day'];
        $time = $_POST['time'];
        $ledit = date("d.m.") . " v " . date("H:i");
        $s1 = $_POST['s1'];
        $s2 = $_POST['s2'];
        $a1 = $_POST['a1'];
        $a2 = $_POST['a2'];
        $inf1 = $_POST['inf1'];
        $inf2 = $_POST['inf2'];
        $query = "INSERT INTO lessons (name, url, day, time, lastedit, s1, s2, a1, a2, inf1, inf2) VALUES ('$name', '$url', $day, '$time', '$ledit', $s1, $s2, $a1, $a2, $inf1, $inf2)";
        mysqli_query($sql,$query) or die(mysqli_error());
        notification($_SESSION['username'],$day,"přidal/a hodinu");
        header("location: admin.php");
    } else {
        echo "data not set.";
    }
?>