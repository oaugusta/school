<?php

/**
 * Login script. Pretty basic, nothing to describe.
 * 
 * </> O. Augusta, hello@ondrejaugusta.cz, ondrejaugusta.cz
**/

// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Zadejte uživatelské jméno.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Zadejte své heslo.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sqlq = "SELECT id, username, password, S, A, I, role FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($sql, $sqlq)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $S, $A, $I, $role);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["S"] = $S;
                            $_SESSION["A"] = $A;
                            $_SESSION["INF"] = $I;
                            $_SESSION["role"] = $role;
                            
                            
                            // Redirect user to welcome page
                            header("location: index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "Neplatné heslo.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "Žádný účet s tímto uživatelským jménem.";
                }
            } else{
                echo "Něco se pokazilo.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="cs">
<head>
    <script src="https://kit.fontawesome.com/fcc92e61a4.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1">
    <link rel="icon" type="image/png" href="img/lock.png">
    <title>Přihlásit se</title>
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
            flex-direction: column;
        }
        .wrapper {
            width: 350px;
            padding: 20px;
            border-radius: 5%;
            box-shadow: 10px 10px 5px grey;
            background-color: #ebebeb;
            border: 2px #cccccc solid;
        }
        .logo {
            width: 100%;
            text-align: center;
        }
        .sbtn {
            display: flex;
            justify-content: space-between;
        }
        .pristup {
            font-size: 0.875em;
            padding: 0;
        }
        .nadpis {
            margin-bottom: 0;
        }
        .alert {
            width: 350px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2 class="nadpis">Požadováno přihlášení</h2>
        <p class="pristup">Musíme vědět, že k tomuto nástroji máte přístup.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Uživatelské jméno</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" placeholder='Třeba "uživatel"'>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Heslo</label>
                <input type="password" name="password" class="form-control" placeholder="Vaše heslo">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group sbtn">
                <a href="mailto:augustaon196@student.gfxs.cz?subject=Žádost o vytvoření v účtu ve školní aplikaci&body=Žádost o vytvoření účtu%0d%0aJméno: [doplnte]%0d%0aSkupiny:%0d%0aS: [1/2]%0d%0aA: [1/2]%0d%0aINF: [1/2]%0d%0aPoznámka pro žadatele: heslo vám bude přiděleno, poté si ho změňte tak, jak je popsáno v nápovědě." class="noacc">Nemáte účet?</a> 
                <input type="submit" class="btn btn-primary sumbitbtn" value="Přihlásit se">
            </div>
        </form>
    </div>    
    <script src="lib/help.js"></script>
</body>
</html>