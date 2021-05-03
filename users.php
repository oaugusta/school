<?php
/**
 * User management system. Hand-crafted.
 * 
 * </> O. Augusta, hello@ondrejaugusta.cz, ondrejaugusta.cz
**/

require_once "config.php";
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

$q = "SELECT * FROM users ORDER BY username";
$d = mysqli_query($sql,$q);

?>
<!doctype html>
<html>
    <head>
        <title>Správa uživatelů</title>
       <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <style type="text/css">
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            .tg  {border-collapse:collapse;border-color:#93a1a1;border-spacing:0;}
            .tg td{background-color:#fdf6e3;border-color:#93a1a1;border-style:solid;border-width:0.1px;color:#002b36;
              font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;word-break:normal;}
            .tg th{background-color:#657b83;border-color:#93a1a1;border-style:solid;border-width:0.1px;color:#fdf6e3;
              font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
            .tg .tg-v0nz{background-color:#ffffff;border-color:#93a1a1;color:#000000;text-align:center;vertical-align:center}
            .tg .tg-l49g{border-color:#93a1a1;color:#ffffff;text-align:center;vertical-align:center}
        </style> 
    </head>
    <body>
        <table class="tg">
            <thead>
              <tr>
                <th class="tg-l49g">ID</th>
                <th class="tg-l49g">Uživatel</th>
                <th class="tg-l49g">S</th>
                <th class="tg-l49g">A</th>
                <th class="tg-l49g">INF</th>
                <th class="tg-l49g">Akce</th>
              </tr>
            </thead>
            <tbody>
              <?php
                while($r = mysqli_fetch_array($d)) {
                    echo '<tr>';
                        echo '<td class="tg-v0nz">'.$r['id'].'</td>';
                        echo '<td class="tg-v0nz">'.$r['username'].'</td>';
                        echo '<td class="tg-v0nz">'.$r['S'].'</td>';
                        echo '<td class="tg-v0nz">'.$r['A'].'</td>';
                        echo '<td class="tg-v0nz">'.$r['I'].'</td>';
                        if ($_SESSION["id"] == $r['id']) { echo '<td class="tg-v0nz"><button class="btn btn-sm btn-danger" disabled><i class="fas fa-dumpster"></i></button></td>'; } else { echo '<td class="tg-v0nz"><a href="userdelete.php?id='.$r['id'].'"><button class="btn btn-sm btn-danger"><i class="fas fa-dumpster"></i></button></a></td>'; }
                    echo '</tr>';
                }
              ?>
              <tr>
                  <td colspan=6 class="tg-v0nz"><a href="admin.php"><button class="btn btn-sm btn-success"><i class="fas fa-undo"></i> Zpět</button></a></td>
              </tr>
            </tbody>
        </table>
        <script src="lib/help.js"></script>
    </body>
</html>