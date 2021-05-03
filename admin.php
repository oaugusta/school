<?php
/**
 * This PHP file serves the function of an admin panel of this service.
 * This page is password-protected, it doesn't prevent SQL injection tho.
 * This is a file no one knows about. The students should ever visit the
 * first "index.php" page.
 * This page uses Bootstrap CSS+JS to work.
 * 
 * Made by Ondřej Augusta, hello@ondrejaugusta.cz, ondrejaugusta.cz
**/
require_once "config.php";

session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] == "user"){
    header("location: login.php");
    exit;
}


$result = mysqli_query($sql,"SELECT * FROM lessons ORDER BY day, time");
?>
<!DOCTYPE html>
<html lang="cs">
    <head>
        <link rel="icon" type="image/png" href="img/manage.png">
        <title>Správcovské rozhraní</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <style>
            body {
                width: 100vw;
                display: flex;
                justify-content: center;
                align-items: center;
                overflow-x: hidden;
            }
            table {
                margin-top: 5px;
                margin-bottom: 5px;
            }
        </style>
    </head>
    <body>
        <style type="text/css">
            .tg  {border-collapse:collapse;border-color:#93a1a1;border-spacing:0;}
            .tg td{background-color:#ffffff;border-color:#93a1a1;border-style:solid;border-width:1px;color:#000000;
              font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;word-break:normal;}
            .tg th{background-color:#657b83;border-color:#93a1a1;border-style:solid;border-width:1px;color:#ffffff;
              font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
            .tg .tg-baqh{text-align:center;vertical-align:center}
        </style>
        <table class="tg">
        <thead>
          <tr>
            <th class="tg-baqh">Název předmětu</th>
            <th class="tg-baqh">S1</th>
            <th class="tg-baqh">S2</th>
            <th class="tg-baqh">A1</th>
            <th class="tg-baqh">A2</th>
            <th class="tg-baqh">INF1</th>
            <th class="tg-baqh">INF2</th>
            <th class="tg-baqh">URL předmětu</th>
            <th class="tg-baqh">Den v týdnu</th>
            <th class="tg-baqh">Čas</th>
            <th class="tg-baqh">Naposledy upraveno</th>
            <th class="tg-baqh">Akce</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <?php
            if (mysqli_num_rows($result) != 0) {
              while($row = mysqli_fetch_array($result))
                    {
                        switch ($row['day']) {
                            case 1:
                                $fday = "Pondělí";
                                break;
                            case 2:
                                $fday = "Úterý";
                                break;
                            case 3:
                                $fday = "Středa";
                                break;
                            case 4:
                                $fday = "Čtvrtek";
                                break;
                            case 5:
                                $fday = "Pátek";
                                break;
                            default:
                                $fday = "Nenastaveno!";
                                break;
                        }
                        switch ($row['time']) {
                            case "445":
                                $ftime = "07:25";
                                break;
                            case "500":
                                $ftime = "08:20";
                                break;
                            case "555":
                                $ftime = "09:15";
                                break;
                            case "620":
                                $ftime = "10:20";
                                break;
                            case "675":
                                $ftime = "11:15";
                                break;
                            case "730":
                                $ftime = "12:10";
                                break;
                            case "785":
                                $ftime = "13:05";
                                break;
                            case "835":
                                $ftime = "13:55";
                                break;
                            case "890":
                                $ftime = "14:50";
                                break;
                            case "945":
                                $ftime = "15:45";
                                break;
                            default:
                                $ftime = "00:00";
                                break;
                        }
                        
                        if($row['s1'] == 0) {
                            $s1yc = "";
                            $s1nc = "checked='checked'";
                        } else if($row['s1'] == 1) {
                            $s1yc = "checked='checked'";
                            $s1nc = "";
                        }
                        if($row['s2'] == "0") {
                            $s2yc = "";
                            $s2nc = "checked";
                        } else if($row['s2'] == "1") {
                            $s2yc = "checked";
                            $s2nc = "";
                        }
                        if($row['a1'] == 0) {
                            $a1yc = "";
                            $a1nc = "checked";
                        } else if($row['a1'] == 1) {
                            $a1yc = "checked";
                            $a1nc = "";
                        }
                        if($row['a2'] == 0) {
                            $a2yc = "";
                            $a2nc = "checked";
                        } else if($row['a2'] == 1) {
                            $a2yc = "checked";
                            $a2nc = "";
                        }
                        if($row['inf1'] == 0) {
                            $i1yc = "";
                            $i1nc = "checked";
                        } else if($row['inf1'] == 1) {
                            $i1yc = "checked";
                            $i1nc = "";
                        }
                        if($row['inf2'] == 0) {
                            $i2yc = "";
                            $i2nc = "checked";
                        } else if($row['inf2'] == 1) {
                            $i2yc = "checked";
                            $i2nc = "";
                        }
                        
                        echo "<tr>";
                            echo "<td class='tg-baqh'>" . $row['name'] . "</td>";
                            echo "<td class='tg-baqh'>" . $row['s1'] . "</td>";
                            echo "<td class='tg-baqh'>" . $row['s2'] . "</td>";
                            echo "<td class='tg-baqh'>" . $row['a1'] . "</td>";
                            echo "<td class='tg-baqh'>" . $row['a2'] . "</td>";
                            echo "<td class='tg-baqh'>" . $row['inf1'] . "</td>";
                            echo "<td class='tg-baqh'>" . $row['inf2'] . "</td>";
                            echo "<td class='tg-baqh'>" . $row['url'] . "</td>";
                            echo "<td class='tg-baqh'>" . $fday . "</td>";
                            echo "<td class='tg-baqh'>" . $ftime . "</td>";
                            echo "<td class='tg-baqh'>" . $row['lastedit'] . "</td>";
                            echo '<td class="tg-baqh"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editmodal'.$row['id'].'"><i class="fas fa-pen-square"></i></button> <a href="del.php?id='.$row['id'].'&day='.$row['day'].'"><button class="btn btn-sm btn-danger"><i class="fas fa-dumpster"></i></button></a></td>';
                        echo "</tr>";
                        echo '
                            <div class="modal fade" id="editmodal'.$row['id'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Upravit hodinu</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="edit.php?id='.$row['id'].'" method="post">
                                        ID: <b><span class="text-muted">' . $row['id'] .'</span></b><br>
                                        URL: <input type="text" name="url" value="'. $row['url'] .'"><br>
                                        Den (1-5): <input type="text" name="day" value="'. $row['day'] .'"><br>
                                        V <input type="text" name="time" value="'. $row['time'] .'"><br>
                                        S1: <input type="radio" name="s1" value=0 ' . $s1nc . '> Ne <input type="radio" name="s1" value=1 ' . $s1yc . '> Ano<br>
                                        S2: <input type="radio" name="s2" value=0 ' . $s2nc . '> Ne <input type="radio" name="s2" value=1 ' . $s2yc . '> Ano<br>
                                        A1: <input type="radio" name="a1" value=0 ' . $a1nc . '> Ne <input type="radio" name="a1" value=1 ' . $a1yc . '> Ano<br>
                                        A2: <input type="radio" name="a2" value=0 ' . $a2nc . '> Ne <input type="radio" name="a2" value=1 ' . $a2yc . ' ' . $s1nc . '> Ano<br>
                                        INF1: <input type="radio" name="inf1" value=0 ' . $i1nc . '> Ne <input type="radio" name="inf1" value=1 ' . $i1yc . '> Ano<br>
                                        INF2: <input type="radio" name="inf2" value=0 ' . $i2nc . '> Ne <input type="radio" name="inf2" value=1 ' . $i2yc . '> Ano<br>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zrušit</button>
                                    <input type="submit" class="btn btn-primary" value="Uložit změny">
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                        ';
                    }
                    mysqli_close($sql);
                } else {
                    echo "<td colspan=12 class='tg-baqh'><span class='text-muted'>Nenalezeny žádné záznamy</span></td>";
                }
              ?>
          </tr>
          <tr>
              <td colspan=12 class="tg-baqh">
                  <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addmodal"><i class="fas fa-plus"></i> Přidat</button> <?php if($_SESSION['role'] == "superadmin") { echo '<a href="register.php"><button class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Přidat uživatele</button></a>'; } else { echo '<button class="btn btn-sm btn-primary" disabled><i class="fas fa-plus"></i> Přidat uživatele</button>'; } ?>  <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#cheatmodal">Cheatsheet</button> <a href="logout.php"><button class="btn btn-danger btn-sm"><i class="fas fa-sign-out-alt"></i> Odhlásit se</button></a>
              </td>
          </tr>
        </tbody>
        </table>
        <div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Přidat hodinu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="add.php" method="post">
                    <select name="name">
                        <option disabled selected>Předmět</option>
                        <option value="Aj">Anglický jazyk</option>
                        <option value="Bi">Biologie</option>
                        <option value="Čj">Český jazyk</option>
                        <option value="D">Dějepis</option>
                        <option value="DFU">DFU</option>
                        <option value="F">Fyzika</option>
                        <option value="Ge">Geografie</option>
                        <option value="Ch">Chemie</option>
                        <option value="Inf">Informatika</option>
                        <option value="M">Matematika</option>
                        <option value="NJL">Německý jazyk - Linke</option>
                        <option value="NJR">Německý jazyk - Ruckdäschel</option>
                        <option value="NJŠ">Německý jazyk - Šípová</option>
                        <option value="PŘCV - Bi">Přírodovědná cvičení z Bi</option>
                        <option value="PŘCV - Fy">Přírodovědná cvičení z Fy</option>
                        <option value="PŘCV - Ch">Přírodovědná cvičení z Ch</option>
                        <option value="TH">Třídnická hodina</option>
                    </select>
                    <input type="text" name="url" placeholder="URL"><br>
                    <select name="day">
                        <option disabled selected>Den v týdnu</option>
                        <option value="1">Pondělí</option>
                        <option value="2">Úterý</option>
                        <option value="3">Středa</option>
                        <option value="4">Čtvrtek</option>
                        <option value="5">Pátek</option>
                    </select><br>
                    <select name="time">
                        <option disabled selected>Čas</option>
                        <option value="445">07:25</option>
                        <option value="500">08:20</option>
                        <option value="555">09:15</option>
                        <option value="620">10:20</option>
                        <option value="675">11:15</option>
                        <option value="730">12:10</option>
                        <option value="785">13:05</option>
                        <option value="835">13:55</option>
                        <option value="890">14:50</option>
                        <option value="945">15:45</option>
                    </select><br>
                    S1: <input type="radio" name="s1" value=0> Ne <input type="radio" name="s1" value=1 checked> Ano<br>
                    S2: <input type="radio" name="s2" value=0> Ne <input type="radio" name="s2" value=1 checked> Ano<br>
                    A1: <input type="radio" name="a1" value=0> Ne <input type="radio" name="a1" value=1 checked> Ano<br>
                    A2: <input type="radio" name="a2" value=0> Ne <input type="radio" name="a2" value=1 checked> Ano<br>
                    INF1: <input type="radio" name="inf1" value=0> Ne <input type="radio" name="inf1" value=1 checked> Ano<br>
                    INF2: <input type="radio" name="inf2" value=0> Ne <input type="radio" name="inf2" value=1 checked> Ano<br>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zrušit</button>
                <input type="submit" class="btn btn-primary" value="Uložit změny">
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="cheatmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cheatsheet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>7:25 = 445 ...</p>
                <p>8:20 = 500 ...</p>
                <p>9:15 = 555 ...</p>
                <p>10:20 = 620 ...</p>
                <p>11:15 = 675 ...</p>
                <p>12:10 = 730 ...</p>
                <p>13:05 = 785 ...</p>
                <p>13:55 = 835 ...</p>
                <p>14:50 = 890 ...</p>
                <p>15:45 = 945 ...</p>
                <p>... minut od půlnoci</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
              </div>
            </div>
          </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
        <script src="lib/help.js"></script>
    </body>
</html>