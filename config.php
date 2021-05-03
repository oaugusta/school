<?php
/**
 * This file makes the initial connection to the DB. It is called by
 * every file in this project.
 * 
 * Made by Ondřej Augusta, hello@ondrejaugusta.cz, ondrejaugusta.cz
**/
    $host = 'innodb.endora.cz';
    $user = 'schooldb';
    $password = 'Z8kBFYcZoR';
    $database = 'schooldb';
    $sql = mysqli_connect($host, $user, $password, $database);
    if (mysqli_connect_errno()) {
        exit('Connect failed: '. mysqli_connect_error());
    }
?>