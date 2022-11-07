<?php

require ('../bbdd.php');


try {

    $bd = new PDO($access["dsn"], $access["userName"], $access["password"]);
    $sql = "select name, password from credentials";
    $dbResponse = $bd->query($sql);

    echo "Numero de Registros devueltos: " . $dbResponse->rowCount() . "<hr>";

    if ($dbResponse->rowCount() > 0) {
        foreach ($dbResponse as $row) {
            echo "<br>" . "Name: " . $row['name'];
            echo "<br>" . "Password: " . $row['password'];
            echo "<br>";
        }
    }


} catch (PDOException $e) {

    echo "Error al conectar con la base de datos: " . "<br>" . $e->getMessage();
}