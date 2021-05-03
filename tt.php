<?php

session_start();

/**
 * A timetable that allows group changing, but at first
 * it shows data based on the groups connected with account,
 * that the user is logged in with.
 * 
 * </> O. Augusta, hello@ondrejaugusta.cz, ondrejaugusta.cz
**/ 
    require_once "config.php";
    
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    
    $gs = $_SESSION["S"];
    $ga = $_SESSION["A"];
    $gi = $_SESSION["INF"];
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
            $gs = $_POST['S'];
            $ga = $_POST['A'];
            $gi = $_POST['I'];
    }
    
    if ($gs == 1) {
        if ($ga == 1) {
            if ($gi == 1) {
                $q = "SELECT * FROM lessons WHERE s1=1 and a1=1 and inf1=1";
            } else if ($gi == 2) {
                $q = "SELECT * FROM lessons WHERE s1=1 and a1=1 and inf2=1";
            }
        } else if ($ga == 2) {
            if ($gi == 1) {
                $q = "SELECT * FROM lessons WHERE s1=1 and a2=1 and inf1=1";
            } else if ($gi == 2) {
                $q = "SELECT * FROM lessons WHERE s1=1 and a2=1 and inf2=1";
            }
        }
    } else if ($gs == 2) {
        if ($ga == 1) {
            if ($gi == 1) {
                $q = "SELECT * FROM lessons WHERE s2=1 and a1=1 and inf1=1";
            } else if ($gi == 2) {
                $q = "SELECT * FROM lessons WHERE s2=1 and a1=1 and inf2=1";
            }
        } else if ($ga == 2) {
            if ($gi == 1) {
                $q = "SELECT * FROM lessons WHERE s2=1 and a2=1 and inf1=1";
            } else if ($gi == 2) {
                $q = "SELECT * FROM lessons WHERE s2=1 and a2=1 and inf2=1";
            }
        }
    } else {
        $err = "Chyba";
    }
    
    if (isset($_GET['flush'])) {
        if ($_GET['flush'] == "y") {
            $gs = $_SESSION["S"];
            $ga = $_SESSION["A"];
            $gi = $_SESSION["INF"];
        }
    }
    
?>
<!DOCTYPE html>
<html lang="cs">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">.
        <title>Rozvrh hodin</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
        <style>
            * {margin:0;padding:0;box-sizing:border-box;}
            body {height:100vh;width:100vw;display:flex;justify-content:center;align-items:center;
            font-family:Arial,sans-serif;flex-direction:column;text-align:center;}
            h2 {padding-bottom:5px;}
            a {text-decoration:none;font-weight:bold;color:black;}
            a:hover {text-decoration:underline;color:#32CD32;}
            .tg  {border-collapse:collapse;border-color:#9ABAD9;border-spacing:0;width:50%;}
            .tg td{background-color:#EBF5FF;border-color:#9ABAD9;border-style:solid;border-width:0.1px;color:#444;
              font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;word-break:normal;width:9%;}
            .tg th{background-color:#409cff;border-color:#9ABAD9;border-style:solid;border-width:0.1px;color:#fff; width:9%;
              font-family:Arial, sans-serif;font-size:14px;font-weight:bold;overflow:hidden;padding:10px 5px;word-break:normal;}
            .tg .tg-jicc{background-color:#409cff;color:#ffffff;text-align:center;vertical-align:center;font-weight:bold;}
            .tg .tg-baqh{text-align:center;vertical-align:center}
            .tg .tg-yc5w{border-color:inherit;color:#ffffff;text-align:center;vertical-align:center}
            .tg .tg-8nlf{background-color:#409cff;border-color:inherit;color:#ffffff;text-align:center;vertical-align:center}
            .tg .tg-3xi5{background-color:#ffffff;border-color:inherit;text-align:center;vertical-align:center}
            .thlink {
                color: white;
            }
            .thlink:hover {
                color: black;
            }
            .ib {
                display: inline-block;
            }
            .ar {
                text-align: right;
            }
            .al {
                text-align: left;
            }
            #small { font-size: 0.75em; }
            @media only screen and (max-width: 767px) {
                .tg {
                    width: 90%;
                }
                #settings {
                    display: none;
                }
                #dv {
                    display: none;
                }
            }
        </style>
    </head>
    <body>
        <h2>Rozvrh hodin třídy 2N <span id="dv">(dist. výuka)</span></h2>
        <table class="tg">
        <thead>
          <tr>
            <th class="tg-baqh">S<?php echo $gs;?>, A<?php echo $ga;?>, INF<?php echo $gi;?></th>
            <th class="tg-baqh">1</th>
            <th class="tg-baqh">2</th>
            <th class="tg-baqh">3</th>
            <th class="tg-baqh">4</th>
            <th class="tg-baqh">5</th>
            <th class="tg-baqh">6</th>
            <th class="tg-baqh">7</th>
            <th class="tg-baqh">8</th>
            <th class="tg-baqh">9</th>
            <th class="tg-baqh">10</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="tg-jicc">PO</td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=1 and time='445'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=1 and time='500'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=1 and time='555'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=1 and time='620'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=1 and time='675'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=1 and time='730'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=1 and time='785'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=1 and time='835'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=1 and time='890'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=1 and time='945'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
          </tr>
          <tr>
            <td class="tg-jicc">ÚT</td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=2 and time='445'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=2 and time='500'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=2 and time='555'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=2 and time='620'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=2 and time='675'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=2 and time='730'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=2 and time='785'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=2 and time='835'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=2 and time='890'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=2 and time='945'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
          </tr>
          <tr>
            <td class="tg-jicc">ST</td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=3 and time='445'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=3 and time='500'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=3 and time='555'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=3 and time='620'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=3 and time='675'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=3 and time='730'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=3 and time='785'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=3 and time='835'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=3 and time='890'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=3 and time='945'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
          <tr>
            <td class="tg-jicc">ČT</td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=4 and time='445'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=4 and time='500'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=4 and time='555'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=4 and time='620'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=4 and time='675'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=4 and time='730'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=4 and time='785'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=4 and time='835'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=4 and time='890'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=4 and time='945'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
          </tr>
          <tr>
            <td class="tg-jicc">PÁ</td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=5 and time='445'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=5 and time='500'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=5 and time='555'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=5 and time='620'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=5 and time='675'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=5 and time='730'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=5 and time='785'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=5 and time='835'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=5 and time='890'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
            <td class="tg-baqh"><?php $result = mysqli_query($sql,$q . " and day=5 and time='945'"); while ($row = mysqli_fetch_array($result)) { if ($row['url'] == "") { echo $row['name']; } else { echo "<a href='" . $row['url'] . "'>" . $row['name'] . "</a>"; }}?></td>
          </tr>
          <tr id="settings">
              <td class="tg-baqh" colspan=2><?php if($_SESSION['role'] == "user") { echo '<i class="fas fa-user"></i>'; } else { echo '<a href="admin.php"><i class="fas fa-cog"></i></a>';}?> <?php if(strlen($_SESSION['username']) > 13) { echo '<span id="small">'.$_SESSION['username'].'</span>'; } else { echo $_SESSION['username']; }; ?></td>
              <td class="tg-baqh" colspan=7>
                <form class="ib" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                    <input type="radio" name="S" value="1" <?php if($gs==1) { echo "checked"; } ?> <?php if($_SESSION['role']=="user") { echo "disabled"; } ?>> S1 <input type="radio" name="S" value="2" <?php if($gs==2) { echo "checked"; } ?> <?php if($_SESSION['role']=="user") { echo "disabled"; } ?>> S2 --- 
                    <input type="radio" name="A" value="1" <?php if($ga==1) { echo "checked"; } ?> <?php if($_SESSION['role']=="user") { echo "disabled"; } ?>> A1 <input type="radio" name="A" value="2" <?php if($ga==2) { echo "checked"; } ?> <?php if($_SESSION['role']=="user") { echo "disabled"; } ?>> A2 --- 
                    <input type="radio" name="I" value="1" <?php if($gi==1) { echo "checked"; } ?> <?php if($_SESSION['role']=="user") { echo "disabled"; } ?>> INF1 <input type="radio" name="I" value="2" <?php if($gi==2) { echo "checked"; } ?> <?php if($_SESSION['role']=="user") { echo "disabled"; } ?>> INF2 --- 
                    <input type="submit" value="Zobrazit" <?php if($_SESSION['role']=="user") { echo "disabled"; } ?>>
                </form>
                    <?php if($_SESSION['role']=="admin" or $_SESSION['role']=="superadmin") { echo '<a class="ib" href="https://ondrejaugusta.cz/school/tt.php?flush=y"><button>Obnovit</button></a>'; } ?>
              </td>
              <td class="tg-baqh" colspan=2><a href="logout.php"><i class="fas fa-sign-out-alt"></i></a> <a href="pass.php"><i class="fas fa-lock"></i></a> <a href="up.php"><i class="fas fa-upload"></i></a></td>
          </tr>
          <tr id="settings">
            <td colspan=2 class="tg-baqh"><?php echo date("H:i");?></td>
            <td colspan=7 class="tg-baqh"><a href="index.php"><i class="fas fa-undo"></i> Vrátit se zpět</a></td>
            <td colspan=2 class"tg-baqh"><?php echo date("d.m.");?></td>
          </tr>
        </tbody>
        </table>
        <script src="lib/help.js"></script>
    </body>
</html>