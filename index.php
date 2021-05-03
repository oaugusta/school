<?php
session_start();
/**
 * What this PHP file does is, that it redirects a client based
 * on the current date and time. This ensures (s)he attends every 
 * lesson we have and (s)he doesn't miss anything (which is pretty
 * common by the way).
 * 
 * Made by Ondřej Augusta, hello@ondrejaugusta.cz, ondrejaugusta.cz
**/

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";

date_default_timezone_set('Europe/Prague');
$hour = date('G');
$minute = date('i');
$day = date('w');
$m = $hour * 60 + $minute;
if (435 <= $m && $m < 490) {
    $time = "445"; //7:25 (7*60+15)
} else if (490 <= $m && $m < 540) {
    $time = "500"; //8:20 (8*60+20)
} else if (540 <= $m && $m < 600) {
    $time = "555"; //9:15 (9*60+15)
} else if (600 <= $m && $m < 665) {
    $time = "620"; //10:20 (10*60+20)
} else if (665 <= $m && $m < 720) {
    $time = "675"; //11:15 (11*60+5)
} else if (720 <= $m && $m < 775) {
    $time = "730"; //12:10 (12*60+10)
} else if (775 <= $m && $m < 830) {
    $time = "785"; //13:05 (13*60+5)
} else if (830 <= $m && $m < 880) {
    $time = "835"; //13:55 (13*60+55)
} else if (880 <= $m && $m < 935) {
    $time = "890"; //14:50 (14*60+50)
} else if (935 <= $m && $m < 990) {
    $time = "945"; //15:45 (15*60+45)
}

$s = $_SESSION['S'];
$a = $_SESSION['A'];
$i = $_SESSION['INF'];

if ($s == 1) {
    if ($a == 1) {
        if ($i == 1) {
            $aq = "and s1=1 and a1=1 and inf1=1";
        } else if ($i == 2) {
            $aq = "and s1=1 and a1=1 and inf2=1";
        }
    } else if ($a == 2) {
        if ($i == 1) {
            $aq = "and s1=1 and a2=1 and inf1=1";
        } else if ($i == 2) {
            $aq = "and s1=1 and a2=1 and inf2=1";
        }
    }
} else if ($s == 2) {
    if ($a == 1) {
        if ($i == 1) {
            $aq = "and s2=1 and a1=1 and inf1=1";
        } else if ($i == 2) {
            $aq = "and s2=1 and a1=1 and inf2=1";
        }
    } else if ($a == 2) {
        if ($i == 1) {
            $aq = "and s2=1 and a2=1 and inf1=1";
        } else if ($i == 2) {
            $aq = "and s2=1 and a2=1 and inf2=1";
        }
    }
}

$query = "select * from lessons where time='" . $time . "' and day=" . $day . " " . $aq;
    $result = mysqli_query($sql,$query);
    while ($row = mysqli_fetch_array($result)) {
        $url = $row['url'];
    }

if (!isset($time) or $url == "" or $day==6 or $day==0) {
    echo '
    <!doctype html>
    <html lang="cs">
        <head>
            <link rel="icon" type="image/png" href="img/redirect.png">
            <style>
                * { padding:0;margin:0;box-sizing:border-box; }
                body { display:flex;justify-content:center;align-items:center;width:100vw;height:100vh;text-align:center; }
                p { font-family:sans-serif;font-size:2em; }
                a { color:red;font-size:0.8em; }
                a:hover { font-weight:bold; }
            </style>
            <meta charset="UTF-8">
            <title>Nemáme hodinu</title>
        </head>
        <body>
            <p>Teď není žádná hodina nebo pro ni nebyl nastaven odkaz.<br><a href="tt.php">Podívejte se na rozvrh hodin</a></p>
            <script src="lib/help.js"></script>
        </body>
    </html>
    ';
} else {
    echo '
    <!DOCTYPE html>
    <html>
    <head>
    <style>
    * { padding:0;margin:0;box-sizing:border-box; }
    body { display:flex;justify-content:center;align-items:center;width:100vw;height:100vh;text-align:center; }
    p { font-family:sans-serif;font-size:2em; }
    a { color:red;font-size:0.8em; }
    a:hover { font-weight:bold; }
    </style>
    <meta charset="UTF-8">
    <title>Probíhá přesměrování</title>
    </head>
    <body>
    <p><a href="tt.php">Zrušit přesměrování - přejít na rozvrh</a></p>
    <script src="lib/help.js"></script>
    </body>
    </html>
    ';
    header("refresh:3;url=".$url);
}