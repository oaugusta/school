<?php

/**
 * Very simple logout script, only destroys the session.
 * 
 * </> O. Augusta, hello@ondrejaugusta.cz, ondrejaugusta.cz
**/

session_start();
$_SESSION = array();
session_destroy();
header("location: login.php");
exit;
?>