<?php

//this file is a cron-called file with a period of 10 minutes

require_once "../config.php";
require_once "../notification.php";

date_default_timezone_set('Europe/Prague');
$hour = date('G');
$minute = date('i');
$day = date('w');
$m = $hour * 60 + $minute;
if (435 <= $m && $m < 445) {
    $time = "445"; //7:25 (7*60+15)
} else if (490 <= $m && $m < 500) {
    $time = "500"; //8:20 (8*60+20)
} else if (545 <= $m && $m < 555) {
    $time = "555"; //9:15 (9*60+15)
} else if (610 <= $m && $m < 620) {
    $time = "620"; //10:20 (10*60+20)
} else if (665 <= $m && $m < 675) {
    $time = "675"; //11:15 (11*60+5)
} else if (720 <= $m && $m < 730) {
    $time = "730"; //12:10 (12*60+10)
} else if (775 <= $m && $m < 785) {
    $time = "785"; //13:05 (13*60+5)
} else if (830 <= $m && $m < 835) {
    $time = "835"; //13:55 (13*60+55)
} else if (880 <= $m && $m < 890) {
    $time = "890"; //14:50 (14*60+50)
} else if (935 <= $m && $m < 945) {
    $time = "945"; //15:45 (15*60+45)
}

switch ($time) {
    case "445":
        $t = "7:25";
        break;
    case "500":
        $t = "8:20";
        break;
    case "555":
        $t = "9:15";
        break;
    case "620":
        $t = "10:20";
        break;
    case "675":
        $t = "11:15";
        break;
    case "730":
        $t = "12:10";
        break;
    case "785":
        $t = "13:05";
        break;
    case "835":
        $t = "13:55";
        break;
    case "890":
        $t = "14:50";
        break;
    case "945":
        $t = "15:45";
        break;
}

if (isset($time) && !empty($time)) {
    $query = "select * from lessons where time='" . $time . "' and day=" . $day;
    $result = mysqli_fetch_all(mysqli_query($sql,$query), MYSQLI_ASSOC);
    
    for ($i = 0; $i < count($result); $i++) {
        $name = $result[$i]['name'];
        $url = $result[$i]['url'];
        $groups = array(
            "S1" => $result[$i]['s1'],
            "S2" => $result[$i]['s2'],
            "A1" => $result[$i]['a1'],
            "A2" => $result[$i]['a2'],
            "INF1" => $result[$i]['inf1'],
            "INF2" => $result[$i]['inf2']
        );

         $na = count(array_keys($groups, 0));
        if ($na == 0) {
            $affectedgroups = "všechny skupiny";
        } else if ($na == 1) {
            $affectedgroups = "všechny skupiny kromě " . array_search(0, $groups);
        } else { $affectedgroups = "N/A"; }
        
        if (!isset($url) or $day==6 or $day==0) { echo "It's either Saturday or Sunday, or no record in the DB found.";} else if ($name !== "TH") {
            $text = "V ".$t." začíná hodina ".$name.". Připojte se na ni kliknutím na toto oznámení či přes webovou aplikaci. Toto upozornění platí pro ".$affectedgroups.".";
            reminder($name,$text,$url);
            echo "Reminder sent to all the devices connected to this IFTTT account.";
        } else if ($name == "TH") {
            $text = "Koná se třídnická hodina - začíná v ".$t.". Připojte se na ni kliknutím na toto oznámení či přes webovou aplikaci.";
            reminder("Třídnická hodina",$text,$url);
            echo "Reminder (about the class-thingies lesson) sent to all the devices connected to this IFTTT account.";
        }
    }
} else { echo "Sorry, in the upcoming 10 minutes there is (according to the timetable) no lesson. Try it again next time!"; }