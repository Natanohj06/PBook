<?php
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'pijabook';

    $conx = @mysqli_connect($host,$user,$password,$db);

    if (!$conx) {
        print("ERROR DE CONEXION");
    }
?>