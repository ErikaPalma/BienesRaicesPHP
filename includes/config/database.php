<?php

function conectarDB(): mysqli
{

    $host = 'localhost';
    $user = 'root';
    $password = 'root';
    $database = 'bienes_raices';

    $db = mysqli_connect($host, $user, $password, $database);

    if (!$db) {
        echo "Error en la conexión";
        exit;
    }
    return $db;
}
