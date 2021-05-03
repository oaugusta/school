<?php
/**
 * Registers a user.
 * 
 * </> O. Augusta, hello@ondrejaugusta.cz, ondrejaugusta.cz
**/

// Include config file
require_once "config.php";
 
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== "superadmin"){
    header("location: login.php");
    exit;
}
 
// Define variables and initialize with empty values
$username = $email = $s = $a = $inf = $password = $confirm_password = "";
$username_err = $email_err = $s_err = $a_err = $inf_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Zadejte uživatelské jméno";
    } else{
        // Prepare a select statement
        $qsql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($sql, $qsql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Toto uživatelské jméno již někomu patří.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Něco se pokazilo.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    if(empty(trim($_POST["email"]))){
        $email_err = "Zadejte e-mail";
    } else{
        // Prepare a select statement
        $qsql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($sql, $qsql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                $email = trim($_POST["email"]);
            } else{
                echo "Něco se pokazilo.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    if(empty($_POST["s"])){
        $s_err = "Zadejte skupinu S";     
    } else{
        $s = $_POST["s"];
    }
    
    if(empty($_POST["a"])){
        $a_err = "Zadejte skupinu A";     
    } else{
        $a = $_POST["a"];
    }
    
    if(empty($_POST["inf"])){
        $inf_err = "Zadejte skupinu INF";     
    } else{
        $inf = $_POST["inf"];
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Zadejte heslo";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Heslo musí mít nejméně 6 znaků.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Potvrďte vaše heslo";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Hesla se neshodují.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($s_err) && empty($a_err) && empty($inf_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $qsql = "INSERT INTO users (username, email, S, A, I, password, role) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($sql, $qsql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssiiiss", $param_username, $param_email, $param_s, $param_a, $param_inf, $param_password, $role);
            
            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_s = (int)$s;
            $param_a = (int)$a;
            $param_inf = (int)$inf;
            $role = "user";
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: admin.php");
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
    <title>Zaregistrovat se</title>
    <meta name="viewport" content="initial-scale=1">
    <link rel="icon" type="image/png" href="img/plus.png">
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
        <h2 class="nadpis">Vytvořte nový účet</h2>
        <p class="pristup">Udělte někomu přístup do tohoto systému</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Uživatelské jméno</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>E-mail</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($s_err)) ? 'has-error' : ''; ?>">
                <label>S</label>
                <input type="number" name="s" class="form-control" value="<?php echo $s; ?>" min=1 max=2>
                <span class="help-block"><?php echo $s_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($a_err)) ? 'has-error' : ''; ?>">
                <label>A</label>
                <input type="number" name="a" class="form-control" value="<?php echo $a; ?>" min=1 max=2>
                <span class="help-block"><?php echo $a_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($inf_err)) ? 'has-error' : ''; ?>">
                <label>INF</label>
                <input type="number" name="inf" class="form-control" value="<?php echo $inf; ?>" min=1 max=2>
                <span class="help-block"><?php echo $inf_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Heslo</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Potvrďte heslo</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group sbtn">
                <input type="submit" class="btn btn-primary" value="Potvrdit">
            </div>
        </form>
    </div>    
    <script src="lib/help.js"></script>
</body>
</html>