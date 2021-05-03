<?php
/**
 * This script changes the password of a user.
 * 
 * </> O. Augusta, hello@ondrejaugusta.cz, ondrejaugusta.cz
**/
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Zadejte nové heslo.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Heslo musí mít nejméně 6 znaků";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Potvrďte heslo";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Hesla se neshodují";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $qsql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($sql, $qsql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION['id'];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                header("location: tt.php");
            } else{
                echo "Něco se pokazilo.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($sql);
}
?>
 
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1">
    <title>Změnit heslo</title>
    <link rel="icon" href="/img/pencil.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            font: 14px sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .wrapper {
            width: 350px;
            padding: 20px;
            border-radius: 5%;
            box-shadow: 10px 10px 5px grey;
            background-color: #ebebeb;
            border: 2px #cccccc solid;
        }
        .sbtn {
            text-align: right;
        }
        .pristup {
            font-size: 0.875em;
            padding: 0;
        }
        .nadpis {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2 class="nadpis">Změnit heslo</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>Nové heslo</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Potvrďte heslo</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group sbtn">
                <a class="btn btn-link" href="tt.php">Zrušit</a>
                <input type="submit" class="btn btn-primary" value="Odeslat">
            </div>
        </form>
    </div>    
    <script src="lib/help.js"></script>
</body>
</html>