<?php 

/**
 * UI for uploading and deleting files.
 * </> O. Augusta, hello@ondrejaugusta.cz, ondrejaugusta.cz
**/ session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Nahrát soubor</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            .wrapper {
                border: 2px solid black;
                border-radius: 5px;
                text-align: center;
            }
            .sub {
                padding: 20px;
            }
            .header {
                display: inline-block;
                width: 100%;
                margin-bottom: 0px;
                padding-bottom: 0px;
            }
            .subheader {
                width: 100%;
                font-size: 0.75em;
                margin-top: 0px;
                padding-top: 0px;
                margin-bottom: 10px;
            }
            .body {
                width: 100%;
            }
            .del {
                color: red;
            }
            .del:hover {
                color: #7f0000;
            }
            .footer {
                margin-top: 10px;
                width: 100%;
            }
            
            table.greyGridTable {
              border: 4px solid #333333;
              width: 100%;
              text-align: center;
              border-collapse: collapse;
            }
            table.greyGridTable td, table.greyGridTable th {
              border: 1px solid #FFFFFF;
              padding: 3px 4px;
            }
            table.greyGridTable tbody td {
              font-size: 13px;
              border: 2px solid #333333;
            }
            table.greyGridTable thead {
              background: #FFFFFF;
              border-bottom: 2px solid #333333;
            }
            table.greyGridTable thead th {
              font-size: 15px;
              font-weight: bold;
              color: #333333;
              text-align: center;
              border-left: 2px solid #333333;
            }
            table.greyGridTable thead th:first-child {
              border-left: none;
            }
            
            table.greyGridTable tfoot td {
              font-size: 14px;
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <div class="sub">
                <div class="header">
                    <h2>Správce souborů</h2>
                </div>
                <div class="subheader">
                    <span><a href="tt.php"><i class="fas fa-arrow-left"></i></a> / <i class="fas fa-user"></i> <?php echo $_SESSION['username']; ?></span>
                </div>
                <div class="body">
                    <table class="greyGridTable">
                        <thead>
                            <tr>
                                <th>Soubor</th>
                                <th>Smazat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $username = $_SESSION['username'];
                                $mydir = 'uploads'; 
                                $myfiles = scandir($mydir);
                                $i = 0;
                                $c = count($myfiles);
                                while($i < $c) {
                                    if(strpos($myfiles[$i],$username) === false) {}
                                    else {
                                        echo "<tr>";
                                        echo "<td><a href='uploads/" . $myfiles[$i] . "'>" . $myfiles[$i] . "</a></td>";
                                        echo "<td><a class='del' href='deletefile.php?n=" . $myfiles[$i] . "'><i class='fas fa-times'></i></a></td>";
                                        echo "</tr>";
                                    }
                                    $i++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="footer">
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="file" id="fileToUpload">
                        <input type="submit" name="submit" value="Nahrát">
                    </form>
                    <span style="font-weight:bold;" class="text-danger"><?php echo $_SESSION['errormsg']; $_SESSION['errormsg'] = ""; ?></span>
                    <span style="font-weight:bold;" class="text-success"><?php echo $_SESSION['successmsg']; $_SESSION['successmsg'] = ""; ?></span>
                </div>
            </div>
        </div>
        <script src="lib/help.js"></script>
    </body>
</html>