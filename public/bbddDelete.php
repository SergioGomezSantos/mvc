<?php

require ('../bbdd.php');
require ('footerBBDD.php');

try {

    $bd = new PDO($access["dsn"], $access["userName"], $access["password"]);
    $sql = "DELETE from credentials WHERE name = 'name-3' or name = 'name-3 Updated'";
    $dbResponse = $bd->query($sql);

    echo $dbResponse ? "Delete Completado" : "Error al Eliminar";

} catch (PDOException $e) {

    echo "Error al conectar con la base de datos: " . "<br>" . $e->getMessage();
}

footerBBDD(['Select', 'Insert', 'Update']);