<?php

require ('../../bbdd.php');
require ('footerBBDD.php');

try {

    $bd = new PDO($access["dsn"], $access["userName"], $access["password"]);
    $sql = "UPDATE credentials SET name = 'name-3 Updated' WHERE name = 'name-3'";
    $dbResponse = $bd->query($sql);

    echo $dbResponse ? "Update Completado" : "Error al Actualizar";

} catch (PDOException $e) {

    echo "Error al conectar con la base de datos: " . "<br>" . $e->getMessage();
}

footerBBDD(['Select', 'Insert', 'Delete']);