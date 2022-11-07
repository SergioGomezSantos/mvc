<?php

require ('../../bbdd.php');
require ('footerBBDD.php');

$encodedPassword = password_hash('password-3', PASSWORD_BCRYPT);

try {

    $bd = new PDO($access["dsn"], $access["userName"], $access["password"]);
    $sql = "INSERT INTO credentials (name, password) VALUES ('name-3','$encodedPassword')";
    $dbResponse = $bd->query($sql);

    echo $dbResponse ? "Insert Completado" : "Error al Insertar";


} catch (PDOException $e) {

    echo "Error al conectar con la base de datos: " . "<br>" . $e->getMessage();
}

footerBBDD(['Select', 'Update', 'Delete']);