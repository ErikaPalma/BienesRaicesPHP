<?php

//Importar conexión
require 'includes/config/database.php';
$db = conectarDB();

//Crear email y password
$email = 'correo@correo.com';
$password = '123456';
//Argumentos: contraseña a hashear y algoritmo utilizado para ello
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

//Query para crear usuario
$query = "INSERT INTO usuarios (email, password) VALUES ('${email}', '${passwordHash}')";

//echo $query;

//Añadirlo a la BD
mysqli_query($db, $query);
