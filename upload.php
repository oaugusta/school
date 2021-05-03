<?php
/**
 * A script that uploads files.
 * 
 * 
 * </> O. Augusta, hello@ondrejaugusta.cz, ondrejaugusta.cz
**/
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
        $currentDirectory = getcwd();
        $uploadDirectory = "/uploads/";
    
        $errors = [];
    
        $fileExtensionsAllowed = ['jpeg','jpg','png','pdf','docx','doc','xls','xlsx','docm','xlsm','tif','tiff','ppt','pptx','pptm','txt','rtf','svg','sh3d','mp3','gif','xcf','zip'];
    
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileTmpName  = $_FILES['file']['tmp_name'];
        $fileType = $_FILES['file']['type'];
        $fileExtension = strtolower(end(explode('.',$fileName)));
        
        $uName = $_SESSION['username'] . "-" . substr(md5($fileName),0,4) . "." . $fileExtension;
    
        $uploadPath = $currentDirectory . $uploadDirectory . basename($uName); 
    
        if (isset($_POST['submit'])) {
    
              if (! in_array($fileExtension,$fileExtensionsAllowed)) {
                $errors[] = "a";
                $_SESSION['errormsg'] = "Nepovolený formát souboru.";
                header("location: up.php");
              }
        
              if ($fileSize > 10000000) {
                $errors[] = "a";
                $_SESSION['errormsg'] = "Soubor přesáhl velikostní limit (10 MB).";
                header("location: up.php");
              }
        
              if (empty($errors)) {
                $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
        
                if ($didUpload) {
                  $_SESSION['successmsg'] = "Soubor úspěšně nahrán (".substr(md5($fileName),0,4).")!";
                  header("location: up.php");
                } else {
                  $_SESSION['errormsg'] = "Nastala nespecifikovaná chyba.";
                  header("location: up.php");
                }
              }
        
            }
?>