<?php

$dsn = "mysql:dbname=demo;host=db";
$user = "dbuser";
$password = "secret";

try {
    
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sentence = $db->prepare("INSERT INTO credentials (name, password) VALUES (:name, :pass)");

    $name = "Name";
    $pass = "1";

    $sentence->bindParam(":name", $name);   // El valor de la variable puede cambiar antes del execute
    $sentence->bindParam(":pass", $pass);

    // $sentence->bindValue(":name", $name);   // El valor de la variable no puede cambiar antes del execute
    // $sentence->bindValue(":pass", $pass);

    $name = "Name2";
    $pass = "2";

    $result = $sentence->execute();
    echo $result;





    $sentence2 = $db->prepare("INSERT INTO credentials (name, password) VALUES (?, ?)");

    $name = "Name3";
    $pass = "3";

    $sentence2->bindParam(1, $name);
    $sentence2->bindParam(2, $pass);

    $result2 = $sentence2->execute();
    echo $result2;





    $sentence3 = $db->prepare("INSERT INTO credentials (name, password) VALUES (:name, :pass)");

    $result3 = $sentence3->execute([":name" => "Name4", ":pass" => "4"]);
    echo $result3;

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}