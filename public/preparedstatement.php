<?php

$dsn = "mysql:dbname=demo;host=db";
$user = "dbuser";
$password = "secret";

try {
    
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sentence = $db->prepare("INSERT INTO credentials (name, password) VALUES (:name, :pass)");
    $name = "Name";
    $pass = "1234";
    $sentence->bindParam(":name", $name);
    $sentence->bindParam(":pass", $pass);

    $result = $sentence->execute();
    echo $result;

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}